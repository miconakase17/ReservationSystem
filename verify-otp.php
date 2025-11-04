<?php
session_start();

// Make sure email is set
if (!isset($_SESSION['reset_email'])) {
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
    <title>Verify OTP - Kevin's Express Studio</title>
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3>Enter OTP</h3>
        <?php if($popup_message) echo "<p style='color:red;'>$popup_message</p>"; ?>
        <form action="process/VerifyOTPProcess.php" method="post">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>
