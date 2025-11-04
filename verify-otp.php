
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
        <form action="process/VerifyOTPProcess.php" method="post">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>
