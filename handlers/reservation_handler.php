<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'];
    $bandName = $_POST['band_name'];
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $service = $_POST['service'];

    // Use shared Database connector (config/database.php)
    require_once __DIR__ . '/../config/database.php';
    try {
        $conn = Database::connect();
    } catch (Exception $ex) {
        // log and redirect back with failure
        $logDir = __DIR__ . '/../uploads/logs/';
        if (!is_dir($logDir)) mkdir($logDir, 0755, true);
        file_put_contents($logDir . 'db_connect.log', '['.date('Y-m-d H:i:s').'] Handler DB connect exception: ' . $ex->getMessage() . "\n", FILE_APPEND);
        header("Location: ../reservation-dashboard.php?reserved=0");
        exit();
    }

    // Fetch user details (stored in user_details table)
    $stmt = $conn->prepare("SELECT firstName, lastName FROM user_details WHERE userID = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $userID);
        if ($stmt->execute()) {
            $stmt->bind_result($firstName, $lastName);
            $stmt->fetch();
        } else {
            error_log('Failed to execute user_details query: ' . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log('Failed to prepare user_details query: ' . $conn->error);
    }

    $details = ['reference_no' => null, 'amount' => null];
    $newFileName = null;

    // Normalize POST field names (form uses hyphenated names)
    $bandName = $_POST['band_name'] ?? $_POST['bandname'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['start_time'] ?? $_POST['start-time'] ?? '';
    $endTime = $_POST['end_time'] ?? $_POST['end-time'] ?? '';
    $service = $_POST['service'] ?? '';

    // Helper: get hourly rate for a service on a given date (1=Mon..7=Sun)
    function getHourlyRate($conn, $serviceName, $date) {
        $wd = (int) date('N', strtotime($date)); // 1..7
        $sql = "SELECT sp.hourlyRate
                FROM service_pricings sp
                JOIN services s ON sp.serviceID = s.serviceID
                WHERE s.serviceName = ?
                  AND (
                    (sp.weekdayFrom <= sp.weekdayTo AND ? BETWEEN sp.weekdayFrom AND sp.weekdayTo)
                    OR (sp.weekdayFrom > sp.weekdayTo AND (? >= sp.weekdayFrom OR ? <= sp.weekdayTo))
                  )
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('siii', $serviceName, $wd, $wd, $wd);
        $stmt->execute();
    $hourlyRate = null;
    $stmt->bind_result($hourlyRate);
    $rate = null;
    if ($stmt->fetch()) $rate = (int)$hourlyRate;
        $stmt->close();
        return $rate;
    }

    // Helper: compute billed hours (round up)
    function calculateBilledHours($startTime, $endTime) {
        $s = DateTime::createFromFormat('H:i', $startTime);
        $e = DateTime::createFromFormat('H:i', $endTime);
        if (!$s || !$e) return 0;
        $diff = $e->getTimestamp() - $s->getTimestamp();
        if ($diff <= 0) return 0;
        return (int) ceil($diff / 3600);
    }

    // Helper: sum selected additionals prices by name
    function getAdditionalsTotal($conn, $additionals) {
        if (empty($additionals) || !is_array($additionals)) return 0;
        $placeholders = implode(',', array_fill(0, count($additionals), '?'));
        $types = str_repeat('s', count($additionals));
        $sql = "SELECT SUM(price) as total FROM additionals WHERE addName IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return 0;
        // bind params dynamically
        $params = array_merge([$types], $additionals);
        $tmp = [];
        foreach ($params as $k => $v) $tmp[$k] = & $params[$k];
        call_user_func_array([$stmt, 'bind_param'], $tmp);
        $stmt->execute();
    $total = 0;
    $stmt->bind_result($total);
    $stmt->fetch();
        $stmt->close();
        return (int)($total ?: 0);
    }

    // Compute server-side totals
    $hourlyRate = getHourlyRate($conn, $service, $date);
    $billedHours = calculateBilledHours($startTime, $endTime);
    $additionalsTotal = 0;
    if (isset($_POST['additionals']) && is_array($_POST['additionals'])) {
        $additionalsTotal = getAdditionalsTotal($conn, $_POST['additionals']);
    }
    $computedAmount = 0.00;
    if ($hourlyRate !== null && $billedHours > 0) {
        $computedAmount = ($hourlyRate * $billedHours) + $additionalsTotal;
    }
    // Use computed amount (server authoritative)
    $details['amount'] = number_format((float)$computedAmount, 2, '.', '');

    // Lookup serviceID for the given service name
    function getServiceID($conn, $serviceName) {
        $sql = "SELECT serviceID FROM services WHERE serviceName = ? LIMIT 1";
        $st = $conn->prepare($sql);
        if (!$st) return null;
        $st->bind_param('s', $serviceName);
        $st->execute();
        $serviceID = null;
        $st->bind_result($serviceID);
        if ($st->fetch()) {
            $st->close();
            return (int)$serviceID;
        }
        $st->close();
        return null;
    }

    // Begin transaction to insert reservation and related records atomically
    $conn->begin_transaction();
    $error = false;
    // helper to log reservation errors to a file
    function logReservationError($msg, $conn = null, $userID = null) {
        $logDir = __DIR__ . '/../uploads/logs/';
        if (!is_dir($logDir)) mkdir($logDir, 0755, true);
        $logFile = $logDir . 'reservation_errors.log';
        $time = date('Y-m-d H:i:s');
        $dbErr = '';
        if ($conn && method_exists($conn, 'error')) $dbErr = ' DB_ERR: ' . $conn->error;
        $line = "[$time] userID=" . ($userID ?? 'null') . " MSG=" . $msg . $dbErr . "\n";
        file_put_contents($logFile, $line, FILE_APPEND);
    }
    $serviceID = getServiceID($conn, $service);
    if ($serviceID === null) {
        $error = true;
        $conn->rollback();
        logReservationError('service not found for name: ' . var_export($service, true), $conn, $userID);
        header("Location: ../reservation-dashboard.php?reserved=0");
        exit();
    } else {
        // Default statusID (1 = Active)
        $statusID = 1;

        $insertSql = "INSERT INTO reservations (userID, serviceID, date, startTime, endTime, totalCost, statusID) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        if (!$stmt) {
            $error = true;
            $conn->rollback();
            logReservationError('Prepare failed for reservation insert: ' . $conn->error, $conn, $userID);
            header("Location: ../reservation-dashboard.php?reserved=0");
            exit();
        } else {
            $totalCost = (float)$details['amount'];
            $stmt->bind_param('iisssdi', $userID, $serviceID, $date, $startTime, $endTime, $totalCost, $statusID);
            if (!$stmt->execute()) {
                $error = true;
                $conn->rollback();
                logReservationError('Execute failed for reservation insert: ' . $stmt->error, $conn, $userID);
                header("Location: ../reservation-dashboard.php?reserved=0");
                exit();
            } else {
                $reservationID = $stmt->insert_id;
                $stmt->close();

                // Handle file uploads (rental-image and recording-image) and save to reservation_reciepts
                $uploadDir = __DIR__ . '/../uploads/receipts/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $uploadedFiles = [];
                $fileFields = [
                    'rental-image' => 'receipt',
                    'recording-image' => 'recording_receipt'
                ];

                foreach ($fileFields as $fieldName => $uploadType) {
                    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES[$fieldName]['tmp_name'];
                        $origName = basename($_FILES[$fieldName]['name']);
                        $ext = pathinfo($origName, PATHINFO_EXTENSION);
                        $safeName = time() . '_' . bin2hex(random_bytes(6)) . ($ext ? '.' . $ext : '');
                        $dest = $uploadDir . $safeName;
                        if (move_uploaded_file($tmpName, $dest)) {
                            // insert record into reservation_reciepts
                            $ins = $conn->prepare("INSERT INTO reservation_reciepts (reservationID, upload_type, fileName) VALUES (?, ?, ?)");
                            if ($ins) {
                                $ins->bind_param('iss', $reservationID, $uploadType, $safeName);
                                    if (!$ins->execute()) {
                                        // Non-fatal: record the error but continue
                                        logReservationError('Failed to insert reservation_reciepts: ' . $ins->error, $conn, $userID);
                                    }
                                $ins->close();
                            }
                            $uploadedFiles[] = $safeName;
                        }
                    }
                }

                // If service is Recording, insert recording options
                if (strtolower($service) === 'recording') {
                    $mode = $_POST['recording-mode'] ?? null;
                    $mixAndMaster = (isset($_POST['mix']) && $_POST['mix']) ? 1 : 0;
                    if ($mode) {
                        $insRec = $conn->prepare("INSERT INTO recording_options (reservationID, mode, mixAndMaster) VALUES (?, ?, ?)");
                        if ($insRec) {
                            $insRec->bind_param('isi', $reservationID, $mode, $mixAndMaster);
                            if (!$insRec->execute()) {
                                logReservationError('Failed to insert recording_options: ' . $insRec->error, $conn, $userID);
                            }
                            $insRec->close();
                        }
                    }
                }

                // Commit transaction
                if (!$error) {
                    $conn->commit();
                    // Redirect back to reservation page and signal success so the UI can show a popup
                    header("Location: ../reservation-dashboard.php?reserved=1");
                    exit();
                }
            }
        }
    }

    if ($error) {
        // Ensure connection is closed if we rolled back
        if ($conn->connect_errno === 0) $conn->close();
    } else {
        $conn->close();
    }
}

// Function outside POST block
function extractGCashDetails($text) {
    $details = [];

    if (preg_match('/Reference No:\s*(\w+)/i', $text, $matches)) {
        $details['reference_no'] = $matches[1];
    }

    if (preg_match('/Amount:\s*PHP\s*([\d,]+\.\d{2})/i', $text, $matches)) {
        $details['amount'] = $matches[1];
    }

    return $details; 
}
?>
