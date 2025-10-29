<?php
session_start();
require_once __DIR__ . '/../controller/LoginController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $controller = new LoginController();
    $error = $controller->login($username, $password);

    if ($error) {
        $_SESSION['error'] = $error; // store error for the view
        header("Location: ../views/login.php");
        exit();
    }

    // if no error, redirect to dashboard or home
    header("Location: ../views/customer-dashboard.php");
    exit();
}
?>
