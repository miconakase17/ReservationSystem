<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

// ✅ Get connection from Database class
$conn = Database::getConnection();

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;
if (!$start || !$end) {
    echo json_encode(['error' => 'Missing date range parameters']);
    exit;
}

// 🟢 Fetch main reservations (Studio, Recording, Drum Lesson main)
$sql = "
    SELECT 
        r.reservationID,
        r.serviceID,
        s.serviceName,
        r.date,
        r.startTime,
        r.endTime,
        r.totalCost,
        st.statusName
    FROM reservations r
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    WHERE r.date BETWEEN ? AND ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit;
}
$stmt->bind_param('ss', $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}
$stmt->close();

// 🟣 Fetch Drum Lesson Weekly Sessions (12-week blocks)
$sqlWeekly = "
    SELECT 
        d.sessionID,
        r.reservationID,
        r.serviceID,
        s.serviceName,
        d.date,
        d.startTime,
        d.endTime,
        r.totalCost,
        st.statusName
    FROM drumlesson_sessions d
    INNER JOIN reservations r ON d.reservationID = r.reservationID
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    WHERE d.date BETWEEN ? AND ?
";

$stmtWeekly = $conn->prepare($sqlWeekly);
if ($stmtWeekly) {
    $stmtWeekly->bind_param('ss', $start, $end);
    $stmtWeekly->execute();
    $resultWeekly = $stmtWeekly->get_result();

    while ($row = $resultWeekly->fetch_assoc()) {
        $reservations[] = $row; // merge sessions
    }

    $stmtWeekly->close();
}

$conn->close();

// ✅ Send combined JSON
echo json_encode(['data' => $reservations]);
?>
