<?php
session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/user_model.php';

// Initialize login attempts
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$maxAttempts = 3;
$lockoutTime = 300; // 5 minutes

if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $_SESSION['popup_message'] = "Too many login attempts. Please try again later.";
    header("Location: ../login.php");
    exit();
} elseif (isset($_SESSION['lockout_time']) && time() >= $_SESSION['lockout_time']) {
    // Reset after lockout period
    unset($_SESSION['lockout_time']);
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $database = new Database();
    $db = $database->connect();
    $userModel = new User($db);

    $user = $userModel->findByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['login_attempts'] = 0;
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['firstname'] = $user['firstName'];
        $_SESSION['lastname']  = $user['lastName'];

        header("Location: http://localhost/KevinsExpress/service-details.html?login=success");
        exit();
    } else {
        // Failed login
       $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            $_SESSION['lockout_time'] = time() + $lockoutTime;
            $_SESSION['popup_message'] = "Too many login attempts. Please try again in 5 minutes.";
        } else {
            $remaining = $maxAttempts - $_SESSION['login_attempts'];
            $_SESSION['popup_message'] = "Invalid username or password. You have $remaining attempt(s) left.";
        }

        // Redirect back to login page
        header("Location: ../login.html");
        exit();

    }
}
?>
