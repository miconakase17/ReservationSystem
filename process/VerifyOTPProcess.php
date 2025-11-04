<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$conn = Database::getConnection();

if (!isset($_SESSION['reset_userID'])) {
    header('Location: ../forgot-password.php');
    exit;
}

$userID = $_SESSION['reset_userID'];
$enteredOTP = trim($_POST['otp'] ?? '');

if (empty($enteredOTP)) {
    $_SESSION['popup_message'] = 'Please enter the OTP.';
    header('Location: ../verify-otp.php');
    exit;
}

// Check latest unused OTP for this user
$stmt = $conn->prepare("
    SELECT otpID, otpCode, expiresAt 
    FROM otp_requests 
    WHERE userID = ? AND isUsed = 0 
    ORDER BY createdAt DESC 
    LIMIT 1
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['popup_message'] = 'No valid OTP found. Please request a new one.';
    header('Location: ../forgot-password.php');
    exit;
}

$otpData = $result->fetch_assoc();

// Check if OTP matches
if ($enteredOTP != $otpData['otpCode']) {
    $_SESSION['popup_message'] = 'Incorrect OTP.';
    header('Location: ../verify-otp.php');
    exit;
}

// Check if OTP expired
if (strtotime($otpData['expiresAt']) < time()) {
    $_SESSION['popup_message'] = 'OTP has expired. Please request a new one.';
    header('Location: ../forgot-password.php');
    exit;
}

// Mark OTP as used
$update = $conn->prepare("UPDATE otp_requests SET isUsed = 1 WHERE otpID = ?");
$update->bind_param("i", $otpData['otpID']);
$update->execute();

// OTP is valid → redirect to reset password
$_SESSION['otp_verified'] = true;
header('Location: ../reset-password.php');
exit;
