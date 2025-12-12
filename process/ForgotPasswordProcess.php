<?php
session_start();
date_default_timezone_set('Asia/Manila');

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

// Check if email exists
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

// Secure temporary password generation
function generateTempPassword($length = 8)
{
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+=-{}[]';
    $charLen = strlen($chars);
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $charLen - 1)];
    }

    return $password;
}

$otp = generateTempPassword();
$expiresAt = date('Y-m-d H:i:s', strtotime('+3 minutes'));

// Delete expired temporary passwords
$now = date('Y-m-d H:i:s');
$conn->query("DELETE FROM temporary_passwords WHERE expiresAt < '$now'");


// Insert into otp_requests
$createdAt = date('Y-m-d H:i:s');

$insert = $conn->prepare("
    INSERT INTO temporary_passwords (userID, tempPassword, expiresAt, createdAt) 
    VALUES (?, ?, ?, ?)
");
$insert->bind_param("isss", $userID, $otp, $expiresAt, $createdAt);
$insert->execute();

// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kevinsexpressmusicstudio@gmail.com';
    $mail->Password = 'hxwc boij mmts kglr';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kevinsexpressmusicstudio@gmail.com', 'Kevin\'s Express Studio');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Your Password Reset OTP - Kevin's Express Studio";
    $mail->Body = "
<p>Hello, $email</p>
<p>We received a request to reset your password.</p>
<p>Your temporary password is: <b>$otp</b></p>
<p>This password will expire in 3 minutes. Use it to log in and reset your password immediately.</p>
<p>If you did not request a password reset, please ignore this email.</p>
<p>– Kevin's Express Studio</p>
";

    $mail->send();

    $_SESSION['popup_message'] = 'OTP has been sent to your email.';
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_userID'] = $userID;
    header('Location: ../verify-otp.php');
    exit;

} catch (Exception $e) {
    $_SESSION['popup_message'] = 'Failed to send OTP. Mailer Error: ' . $mail->ErrorInfo;
    header('Location: ../forgot-password.html');
    exit;
}
