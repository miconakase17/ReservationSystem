<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/MessagesModel.php';

class MessagesController
{
    private $db;
    private $messagesModel;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->messagesModel = new MessagesModel($this->db);
    }

    public function login($name, $email, $message)
    {
        session_start();

        $success = $this->messagesModel->createMessages([
            'name' => $name,
            'email' => $email,
            'message' => $message
        ]);

        if ($success) {
            $_SESSION['popup_message'] = "Message sent successfully.";
        } else {
            $_SESSION['popup_message'] = "Failed to send message. Please try again.";
        }

        header("Location: ../index.html");
        exit();
    }
}
?>