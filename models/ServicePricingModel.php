<?php
class ServicePricingModel {
    private $conn;
    private $table = "service_pricings";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Get all pricing rows for a given service ID.
     */
    public function getPricingByServiceID($serviceID) {
        $sql = "SELECT weekdayFrom, weekdayTo, hourlyRate 
                FROM {$this->table} 
                WHERE serviceID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $serviceID);
        $stmt->execute();
        $result = $stmt->get_result();

        $pricing = [];
        while ($row = $result->fetch_assoc()) {
            $pricing[] = $row;
        }
        return $pricing;
    }

    /**
     * Get hourly rate for a specific date and service.
     * Automatically checks weekday range.
     */
    public function getRateForDate($serviceID, $date) {
        $dayOfWeek = date('N', strtotime($date)); // 1=Mon ... 7=Sun
        $sql = "SELECT hourlyRate 
                FROM {$this->table} 
                WHERE serviceID = ? AND ? BETWEEN weekdayFrom AND weekdayTo
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $serviceID, $dayOfWeek);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['hourlyRate'] : 0;
    }
}
?>
