<?php
require_once __DIR__ . '/../controller/ReservationController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userID'] ?? '';
    $serviceID = $_POST['serviceID'] ?? '';
    $date = $_POST['date'] ?? '';
    $startTime = $_POST['startTime'] ?? '';
    $endTime = $_POST['endTime'] ?? '';
    $totalCost = $_POST['totalCost'] ?? '';

    $controller = new ReservationController();
    $controller->createReservation($userID, $serviceID, $date, $startTime, $endTime, $totalCost);
}
?>