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

  public function submitMessage($name, $email, $message)
{
    session_start();

    $ip = $_SERVER['REMOTE_ADDR'];
    $max_messages_per_hour = 5;

    // Check rate limit
    if ($this->messagesModel->countMessagesByIP($ip) >= $max_messages_per_hour) {
        $_SESSION['popup_message'] = "You have reached the message limit. Please try again later.";
        header("Location: ../index.html");
        exit();
    }

    $success = $this->messagesModel->createMessages([
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'ipAddress' => $ip
    ]);

    $_SESSION['popup_message'] = $success ? "Message sent successfully." : "Failed to send message. Please try again.";
    header("Location: ../index.html");
    exit();
}

}
?>