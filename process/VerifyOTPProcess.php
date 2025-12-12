<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$conn = Database::getConnection();

// User must have requested a reset
if (!isset($_SESSION['reset_userID'])) {
    header('Location: ../forgot-password.php');
    exit;
}

$userID = $_SESSION['reset_userID'];
$enteredTempPass = trim($_POST['otp'] ?? '');

if (empty($enteredTempPass)) {
    $_SESSION['popup_message'] = 'Please enter the temporary password.';
    header('Location: ../verify-otp.php');
    exit;
}

// Fetch latest temporary password for this user
$stmt = $conn->prepare("
    SELECT tempID, tempPassword, expiresAt
    FROM temporary_passwords
    WHERE userID = ?
    ORDER BY createdAt DESC
    LIMIT 1
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['popup_message'] = 'Invalid or expired temporary password. Please request a new one.';
    header('Location: ../forgot-password.php');
    exit;
}

$tempData = $result->fetch_assoc();
$tempID   = $tempData['tempID'];
$dbTempPass = $tempData['tempPassword'];
$expiresAt = $tempData['expiresAt'];

// Check if expired
if (strtotime($expiresAt) < time()) {
    // Delete expired temp password
    $del = $conn->prepare("DELETE FROM temporary_passwords WHERE tempID = ?");
    $del->bind_param("i", $tempID);
    $del->execute();

    $_SESSION['popup_message'] = 'Temporary password has expired. Please request a new one.';
    header('Location: ../forgot-password.php');
    exit;
}

// Check if match
if ($enteredTempPass !== $dbTempPass) {
    $_SESSION['popup_message'] = 'Incorrect temporary password.';
    header('Location: ../verify-otp.php');
    exit;
}

// Valid → delete temp password (only one-time use)
$del = $conn->prepare("DELETE FROM temporary_passwords WHERE tempID = ?");
$del->bind_param("i", $tempID);
$del->execute();

// Allow password reset now
$_SESSION['otp_verified'] = true;
header('Location: ../reset-password.php');
exit;
?>
