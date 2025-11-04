<?php
session_start();

// Make sure OTP was verified
if (!isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified']) {
    header('Location: forgot-password.php');
    exit;
}

$popup_message = $_SESSION['popup_message'] ?? '';
unset($_SESSION['popup_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Kevin's Express Studio</title>
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3>Reset Your Password</h3>
        <?php if($popup_message) echo "<p style='color:red;'>$popup_message</p>"; ?>
        <form action="process/ResetPasswordProcess.php" method="post">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
