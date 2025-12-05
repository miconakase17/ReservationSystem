<?php
class ReservationsModel
{
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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new reservation
    public function createReservation()
    {
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

        if ($stmt->execute()) {
            // ✅ Return the inserted reservation ID
            return $this->conn->insert_id;
        }

        return false;

    }

    // Get all reservations
    public function readAllReservations()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY createdAt DESC";
        return $this->conn->query($sql);
    }

    // Get a single reservation by ID
    public function readOne($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update reservation
    public function updateReservations()
    {
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

    public function getUpcomingReservations()
{
    $now = date("Y-m-d H:i:s");

    // Fetch single reservations
    $sql = "SELECT r.*, CONCAT(ud.firstname,' ',ud.lastname) AS userFullName
            FROM reservations r
            JOIN user_details ud ON r.userID = ud.userID
            WHERE CONCAT(r.date,' ',r.startTime) > ?
              AND r.statusID = 1";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $now);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    // Fetch drum lesson weekly sessions
    $sql2 = "SELECT d.*, CONCAT(ud.firstname,' ',ud.lastname) AS userFullName
             FROM drum_lesson_sessions d
             JOIN reservations r ON d.reservationID = r.reservationID
             JOIN user_details ud ON r.userID = ud.userID
             WHERE CONCAT(d.date,' ',d.startTime) > ?
               AND r.statusID = 1";

    $stmt2 = $this->conn->prepare($sql2);
    $stmt2->bind_param("s", $now);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $reservations[] = $row2;
    }

    return $reservations;
}



    // Get reservations by user ID
    public function readReservationsByUserID($userID)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userID = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function isTimeSlotAvailable($date, $startTime, $endTime, $excludeReservationID = null)
    {
        // Convert to 24-hour format with seconds
        $startTime = date('H:i:s', strtotime($startTime));
        $endTime = date('H:i:s', strtotime($endTime));

        $sql = "SELECT COUNT(*) AS count
            FROM {$this->table}
            WHERE date = ?
              AND statusID IN (1,2)  -- Pending or Confirmed
              AND startTime < ?
              AND endTime > ?";

        if ($excludeReservationID) {
            $sql .= " AND reservationID != ?";
        }

        $stmt = $this->conn->prepare($sql);

        if ($excludeReservationID) {
            $stmt->bind_param("sssi", $date, $endTime, $startTime, $excludeReservationID);
        } else {
            $stmt->bind_param("sss", $date, $endTime, $startTime);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] == 0; // true if no conflict
    }

}
?>