<?php
class ReservationsModel {
    private $conn;
    private $table = "reservations";
    
    public $reservationID;
    public $userID;
    public $bandName;
    public $serviceID;
    public $date;
    public $startTime;
    public $endTime;
    public $totalCost;
    public $statusID;
    public $createdAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new reservation
    public function create() {
        $sql = "INSERT INTO {$this->table} 
                  (userID, bandName, serviceID, date, startTime, endTime, totalCost, statusID, createdAt) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isisssdi",
            $this->userID,
            $this->bandName,
            $this->serviceID,
            $this->date,
            $this->startTime,
            $this->endTime,
            $this->totalCost,
            $this->statusID
        );

        return $stmt->execute();
    }

    // Get all reservations
    public function readAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY createdAt DESC";
        return $this->conn->query($sql);
    }

    // Get a single reservation by ID
    public function readOne($id) {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update reservation
    public function update() {
        $sql = "UPDATE {$this->table}
                  SET serviceID = ?, date = ?, startTime = ?, endTime = ?, totalCost = ?, statusID = ?
                  WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isssdii",
            $this->serviceID,
            $this->date,
            $this->startTime,
            $this->endTime,
            $this->totalCost,
            $this->statusID,
            $this->reservationID
        );
        return $stmt->execute();
    }

    // Delete reservation
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get reservations by user ID
    public function readByUser($userID) {
        $sql = "SELECT * FROM {$this->table} WHERE userID = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function isTimeSlotAvailable($serviceID, $date, $startTime, $endTime) {
    $sql = "SELECT COUNT(*) AS count
            FROM {$this->table}
            WHERE serviceID = ?
              AND date = ?
              AND (
                  (startTime <= ? AND endTime > ?) OR
                  (startTime < ? AND endTime >= ?) OR
                  (startTime >= ? AND endTime <= ?)
              )";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param(
        "isssssss",
        $serviceID,
        $date,
        $startTime, $startTime,
        $endTime, $endTime,
        $startTime, $endTime
    );
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] == 0; // true if no conflict
}

}
?>
