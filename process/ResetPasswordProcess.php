<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$conn = Database::getConnection();

if (!isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified'] || !isset($_SESSION['reset_userID'])) {
    header('Location: ../forgot-password.html');
    exit;
}

$userID = $_SESSION['reset_userID'];
$password = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

if (empty($password) || empty($confirmPassword)) {
    $_SESSION['popup_message'] = 'Please fill in all fields.';
    header('Location: ../reset-password.php');
    exit;
}

if ($password !== $confirmPassword) {
    $_SESSION['popup_message'] = 'Passwords do not match.';
    header('Location: ../reset-password.php');
    exit;
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Update password in users table
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE userID = ?");
$stmt->bind_param("si", $hashedPassword, $userID);
$stmt->execute();

// Clear session
unset($_SESSION['otp_verified']);
unset($_SESSION['reset_email']);
unset($_SESSION['reset_userID']);

$_SESSION['popup_message'] = 'Password reset successful. You can now log in.';
$_SESSION['popup_type'] = 'success';
header('Location: ../login.php');
exit;
