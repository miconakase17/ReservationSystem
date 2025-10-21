<?php
require_once __DIR__ . '/../controller/MessagesController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    $controller = new MessagesController();
    $controller->login($name, $email, $message);
}
?>