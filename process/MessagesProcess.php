<?php
session_start(); // always at the top

require_once __DIR__ . '/../controller/MessagesController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['popup_message'] = "All fields are required.";
        header("Location: ../index.html");
        exit();
    }

    $controller = new MessagesController();
    $controller->submitMessage($name, $email, $message);
}
?>
