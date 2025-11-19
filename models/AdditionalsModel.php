<?php
class AdditionalsModel
{
    private $conn;
    private $table = "additionals";

    public $addID;
    public $addName;
    public $price;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create record
    public function createAdditionals()
    {
        $sql = "INSERT INTO $this->table (addName, price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->addName, $this->price);
        return $stmt->execute();
    }

    // Get all records
    public function readAllAdditionals()
    {
        $sql = "SELECT * FROM $this->table ORDER BY addID ASC";
        return $this->conn->query($sql);
    }

    // Get single record by ID
    public function readOneAdditional($id)
    {
        $sql = "SELECT * FROM $this->table WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update record
    public function updateAdditionals()
    {
        $sql = "UPDATE $this->table SET addName = ?, price = ? WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $this->addName, $this->price, $this->addID);
        return $stmt->execute();
    }

    // Delete record
    public function deleteAdditionals($id)
    {
        $sql = "DELETE FROM $this->table WHERE addID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Link additionals to reservation
    public function linkToReservation($reservationID, $addID)
    {
        $sql = "INSERT INTO reservation_additionals (reservationID, addID) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $reservationID, $addID);
        return $stmt->execute();
    }
}
?>