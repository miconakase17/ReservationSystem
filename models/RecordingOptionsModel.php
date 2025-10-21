<?php
class RecordingOptionModel {
    private $conn;
    private $table = "recording_options";

    public $recordingID;
    public $reservationID;
    public $mode;
    public $mixAndMaster;
    public $createdAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Create recording option
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (reservationID, mode, mixAndMaster)
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $data['reservationID'], $data['mode'], $data['mixAndMaster']);
        return $stmt->execute();
    }

    // ✅ Get recording options by reservation
    public function getByReservation($reservationID) {
        $sql = "SELECT * FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Update recording options
    public function update($data) {
        $sql = "UPDATE {$this->table}
                SET mode = ?, mixAndMaster = ?
                WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $data['mode'], $data['mixAndMaster'], $data['reservationID']);
        return $stmt->execute();
    }

    // ✅ Delete recording option (if needed)
    public function delete($reservationID) {
        $sql = "DELETE FROM {$this->table} WHERE reservationID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservationID);
        return $stmt->execute();
    }
}
?>
