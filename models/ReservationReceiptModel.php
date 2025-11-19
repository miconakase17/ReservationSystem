<?php
class ReservationReceiptModel
{
    private $conn;
    private $table = "reservation_receipts";

    public $receiptID;
    public $reservationID;
    public $uploadType;
    public $fileName;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ✅ Upload new receipt record
    public function createReceipt($data = [])
    {
        $sql = "INSERT INTO {$this->table} (reservationID, uploadType, fileName, uploadedAt)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $this->reservationID, $this->uploadType, $this->fileName);
        return $stmt->execute();
    }

    // ✅ Get all receipts for a reservation
    public function getReceiptByReservationId($reservationID)
    {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Delete a specific uploaded file record
    public function deleteReceipt($receiptID)
    {
        $sql = "DELETE FROM {$this->table} WHERE receiptID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $receiptID);
        return $stmt->execute();
    }
}