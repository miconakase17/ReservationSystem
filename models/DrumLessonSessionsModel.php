<?php
class DrumLessonSessionsModel
{
    private $conn;
    private $table = "drumlesson_sessions";

    public $sessionID;
    public $reservationID;
    public $date;
    public $startTime;
    public $endTime;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ✅ Insert a single drum lesson session
    public function createSession()
    {
        $sql = "INSERT INTO {$this->table} (reservationID, date, startTime, endTime) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $this->reservationID, $this->date, $this->startTime, $this->endTime);
        return $stmt->execute();
    }

    // ✅ Insert multiple weekly sessions
    public function createMultipleSessions($reservationID, $sessions)
    {
        $sql = "INSERT INTO {$this->table} (reservationID, date, startTime, endTime) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        foreach ($sessions as $session) {
            $date = $session['date'];
            $startTime = $session['startTime'];
            $endTime = $session['endTime'];
            $stmt->bind_param("isss", $reservationID, $date, $startTime, $endTime);
            $stmt->execute();
        }

        return true;
    }

    // ✅ Fetch all sessions for a reservation
    public function getSessionsByReservation($reservationID)
    {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ✅ Delete all sessions for a reservation
    public function deleteSessionsByReservation($reservationID)
    {
        $sql = "DELETE FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        return $stmt->execute();
    }
}
?>