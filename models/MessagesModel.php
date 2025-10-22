<?php

class MessagesModel {
    private $conn;
    private $table = "messages";

    public $messageID;
    public $name;
    public $email;
    public $message;
    public $createdAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new message
    public function createMessages($data) {
        $sql = "INSERT INTO $this->table (name, email, message) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $data['name'], $data['email'], $data['message']);
        return $stmt->execute();
    }

    // Retrieve all messages
    public function getAllMessages() {
        $sql = "SELECT * FROM $this->table ORDER BY createdAt DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
