<?php
require_once __DIR__ . '/../controller/LoginController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $controller = new LoginController();
    $controller->login($username, $password); // login() handles redirects internally
}
