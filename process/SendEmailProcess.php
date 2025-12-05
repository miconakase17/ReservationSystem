<?php
session_start();
require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if (!$email || !$message) {
    $_SESSION['email_status'] = ['success' => false, 'message' => 'Email or message cannot be empty.'];
    header('Location: ../manage-reservation.php');
    exit;
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kevinsexpressmusicstudio@gmail.com';
    $mail->Password   = 'hxwc boij mmts kglr'; // your app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('kevinsexpressmusicstudio@gmail.com', "Kevin's Express Studio");
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Message from Kevin's Express Studio";

    // Formatted email body
    $mail->Body = "
        <p>Hello, {$email}</p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>
        <p>– Kevin's Express Studio</p>
    ";

    $mail->send();
    $_SESSION['email_status'] = ['success' => true, 'message' => 'Email sent successfully!'];

} catch (Exception $e) {
    $_SESSION['email_status'] = ['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"];
}

header('Location: ../manage-reservation.php');
exit;
