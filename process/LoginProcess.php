<?php
require_once __DIR__ . '/../controller/LoginController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $controller = new LoginController();
    $controller->login($username, $password);
}
?>
