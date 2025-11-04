<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = Database::getConnection();

// Get email from form
$email = trim($_POST['email'] ?? '');
if (empty($email)) {
    $_SESSION['popup_message'] = 'Please enter your email address.';
    header('Location: ../forgot-password.html');
    exit;
}

// Check if email exists in user_details and get userID
$stmt = $conn->prepare("
    SELECT u.userID 
    FROM users u 
    JOIN user_details ud ON u.userID = ud.userID 
    WHERE ud.email = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['popup_message'] = 'No account found with that email.';
    header('Location: ../forgot-password.html');
    exit;
}

$user = $result->fetch_assoc();
$userID = $user['userID'];

// Generate OTP
$otp = rand(100000, 999999);
$expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// Insert OTP into otp_requests table
$insert = $conn->prepare("
    INSERT INTO otp_requests (userID, otpCode, expiresAt, isUsed, createdAt) 
    VALUES (?, ?, ?, 0, NOW())
");
$insert->bind_param("iss", $userID, $otp, $expiresAt);
$insert->execute();

// Send OTP via PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kevinsexpressmusicstudio@gmail.com';
    $mail->Password   = 'hxwc boij mmts kglr';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('kevinsexpressmusicstudio@gmail.com', 'Kevin\'s Express Studio');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Your Password Reset OTP - Kevin's Express Studio";
    $mail->Body    = "
<p>Hello, $email</p>
<p>We received a request to reset your password.</p>
<p>Your One-Time Password (OTP) is: <b>$otp</b></p>
<p>This code will expire in 10 minutes. If you didn’t request this, please ignore this email.</p>
<p>– Kevin's Express Studio</p>
";

    $mail->send();

    $_SESSION['popup_message'] = 'OTP has been sent to your email.';
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_userID'] = $userID; // for OTP verification
    header('Location: ../verify-otp.php');
    exit;

} catch (Exception $e) {
    $_SESSION['popup_message'] = 'Failed to send OTP. Mailer Error: ' . $mail->ErrorInfo;
    header('Location: ../forgot-password.html');
    exit;
}
