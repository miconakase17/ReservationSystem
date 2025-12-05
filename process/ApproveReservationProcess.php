<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "Missing ID"]);
    exit;
}

$id = intval($_POST['id']);
$conn = Database::getConnection();

// 1. Update reservation status
$sql = "UPDATE reservations SET statusID = 2 WHERE reservationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // 2. Fetch customer info and reservation details
    $stmt2 = $conn->prepare("
        SELECT ud.firstName, ud.lastName, ud.email, s.serviceName, r.date, r.startTime, r.endTime
        FROM reservations r
        JOIN user_details ud ON r.userID = ud.userID
        JOIN services s ON r.serviceID = s.serviceID
        WHERE r.reservationID = ?
    ");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $user = $result->fetch_assoc();

    if ($user && !empty($user['email'])) {
        $customerName = $user['firstName'] . ' ' . $user['lastName'];
        $email = $user['email'];
        $serviceType = $user['serviceName'];
        $date = date('F d, Y', strtotime($user['date']));
        $startTime = date('h:i A', strtotime($user['startTime']));
        $endTime = date('h:i A', strtotime($user['endTime']));

        // 3. Send email notification
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kevinsexpressmusicstudio@gmail.com';
            $mail->Password   = 'hxwc boij mmts kglr'; // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('kevinsexpressmusicstudio@gmail.com', "Kevin's Express Studio");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Your Reservation is Approved!";
            $mail->Body = "
                <p>Hello, $customerName</p>
                <p>Your reservation for <b>$serviceType</b> on <b>$date</b> from <b>$startTime</b> to <b>$endTime</b> has been <b>approved</b>.</p>
                <p>Thank you for choosing Kevin's Express Studio.</p>
                <p>– Kevin's Express Studio</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            // Optional: log the error
            // file_put_contents('email_errors.log', $mail->ErrorInfo . PHP_EOL, FILE_APPEND);
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Reservation approved and email sent."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to approve reservation."
    ]);
}

$conn->close();
