<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controller/ReservationsModel.php';

$db = Database::getConnection();
$reservationModel = new ReservationsModel($db);

// Get the count of upcoming reservations
$totalUpcoming = $reservationModel->getUpcomingReservations();

header('Content-Type: application/json');
echo json_encode(['totalUpcoming' => $totalUpcoming]);
