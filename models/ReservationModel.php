<?php
require_once __DIR__ . '/../config/Database.php';

class ReservationModel {
    private $conn;
    private $table = "reservations";
    
    public $reservationID;
    public $userID;
    public $serviceID;
    public $date;
    public $startTime;
    public $endTime;
    public $totalCost;
    public $statusID;
    public $createdAt;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
}
