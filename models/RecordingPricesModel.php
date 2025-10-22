<?php
class RecordingPricesModel {
    private $conn;
    private $table = "recording_options_prices";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all recording options with prices
    public function getAllOptions() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get price by option name
    public function getPriceByName($name) {
        $sql = "SELECT price FROM {$this->table} WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? floatval($row['price']) : 0;
    }
}
?>
