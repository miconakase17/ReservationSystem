<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// reliable paths
$dbPath = __DIR__ . '/../config/database.php';

$autoloadPath = __DIR__ . '/../vendor/autoload.php';

// 1) DB config check
if (!file_exists($dbPath)) {
    error_log("DB config not found at: $dbPath");
    exit('Internal error: DB config missing. Check config/db.php path.');
}
require $dbPath;

// Make sure $pdo exists and is a PDO instance
if (!isset($pdo) || !($pdo instanceof PDO)) {
    error_log('PDO not initialized by config/db.php');
    exit('Internal error: Database connection not found. Check config/db.php.');
}

// 2) PHPMailer autoload (composer) or fallback to manual
if (file_exists($autoloadPath)) {
    require $autoloadPath;
} else {
    // optional: support manual PHPMailer files if you downloaded them
    $manualBase = __DIR__ . '/../PHPMailer/src/';
    if (file_exists($manualBase . 'PHPMailer.php')) {
        require $manualBase . 'Exception.php';
        require $manualBase . 'PHPMailer.php';
        require $manualBase . 'SMTP.php';
    } else {
        error_log("Composer autoload and PHPMailer src not found.");
        exit('Internal error: PHPMailer not installed. Run `composer require phpmailer/phpmailer` or add PHPMailer files.');
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../forgot_password.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Please provide a valid email address.');
}

// Check email in DB
try {
    $stmt = $pdo->prepare("SELECT userId FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // TEMPORARY DEBUG — show exact error
    exit('Database error: ' . $e->getMessage());
}

if (!$user) {
    exit('Email not found.');
}


// Generate OTP
$otp = random_int(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['reset_email'] = $email;
$_SESSION['otp_expire'] = time() + 300; // 5 minutes

// Send OTP
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;

    // Your Brevo SMTP credentials
    $mail->Username   = '962edd002@smtp-brevo.com';
    $mail->Password   = 'c29kM8sNpjg5bKHU';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('962edd002@smtp-brevo.com', "Kevin's Express Studio");
    $mail->addAddress($email);

    $mail->Subject = 'Your OTP Code';
    $mail->isHTML(true);
    $mail->Body    = "<p>Your OTP code is: <b>$otp</b></p><p>This code will expire in 5 minutes.</p>";
    $mail->AltBody = "Your OTP code is: $otp. It will expire in 5 minutes.";

    // Enable debug output
    $mail->SMTPDebug = 2; 
    $mail->Debugoutput = 'html';

    // Send email
    $mail->send();

    // For debugging — show success and SMTP log
    echo "OTP sent successfully to $email";

    // COMMENT OUT redirect while debugging
    // header('Location: ../verify_otp.php');
    // exit();

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

