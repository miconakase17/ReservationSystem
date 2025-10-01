<?php
class Additionals {
    private $conn;
    private $table = "additionals";

    public $addID;
    public $addName;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all records
    public function readAll() {
        $sql = "SELECT * FROM $this->table ORDER BY addID ASC";
        return $this->conn->query($sql);
    }

    // Get single record by ID
    public function readOne($id) {
        $sql = "SELECT * FROM $this->table WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create record
    public function create() {
        $sql = "INSERT INTO $this->table (addName, price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->addName, $this->price);
        return $stmt->execute();
    }

    // Update record
    public function update() {
        $sql = "UPDATE $this->table SET addName = ?, price = ? WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $this->addName, $this->price, $this->addID);
        return $stmt->execute();
    }

    // Delete record
    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
