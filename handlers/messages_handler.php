<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/messages_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'      => $_POST['name'],
        'email'     => $_POST['email'],
        'message'   => $_POST['message'],
        'createdAt' => date('Y-m-d H:i:s')
    ];

    $db = new Database();
    $conn = $db->connect();

    $messageModel = new Message($conn);

    if ($messageModel->create($data)) {
        header("Location: ../contact.php?success=1");
        exit();
    } else {
        echo "Something went wrong while sending your message.";
    }
}
