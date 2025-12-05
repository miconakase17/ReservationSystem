<?php

class MessagesModel
{
    private $conn;
    private $table = "messages";

    public $messageID;
    public $name;
    public $email;
    public $message;
    public $createdAt;
    public $ipAddress;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new message
    // Create a new message
    public function createMessages($data)
    {
        $sql = "INSERT INTO $this->table (name, email, message, ipAddress) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $data['name'], $data['email'], $data['message'], $data['ipAddress']);
        return $stmt->execute();
    }

    public function countMessagesByIP($ip)
    {
        $sql = "SELECT COUNT(*) AS count FROM $this->table WHERE ipAddress = ? AND createdAt > NOW() - INTERVAL 1 HOUR";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] ?? 0;
    }



    // Retrieve all messages
    public function getAllMessages()
    {
        $sql = "SELECT * FROM $this->table ORDER BY createdAt DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
