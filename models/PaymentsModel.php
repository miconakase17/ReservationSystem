<?php
class PaymentsModel {
    private $conn;
    private $table = "payments";

    public $paymentID;
    public $userID;
    public $reservationID;
    public $amount;
    public $paymentDate;
    public $paymentMethod;
    public $paymentStatus;
    public $transactionReference;
    public $createdAt;
    public $lastUpdate;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Create a new payment record
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (userID, reservationID, amount, paymentDate, paymentMethod, paymentStatus, transactionReference)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iisssss",
            $data['userID'],
            $data['reservationID'],
            $data['amount'],
            $data['paymentDate'],
            $data['paymentMethod'],
            $data['paymentStatus'],
            $data['transactionReference']
        );
        return $stmt->execute();
    }

    // ✅ Get all payments by user
    public function getByUser($userID) {
        $sql = "SELECT * FROM {$this->table} WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Get payments by reservation
    public function getByReservation($reservationID) {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Update payment status (e.g. from "Pending" → "Completed")
    public function updateStatus($paymentID, $status) {
        $sql = "UPDATE {$this->table} SET paymentStatus = ?, lastUpdate = NOW() WHERE paymentID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $paymentID);
        return $stmt->execute();
    }

    // ✅ Delete a payment record (if needed)
    public function delete($paymentID) {
        $sql = "DELETE FROM {$this->table} WHERE paymentID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paymentID);
        return $stmt->execute();
    }
}
?>
