<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ReservationsModel.php';

$db = Database::getConnection();
$reservationModel = new ReservationsModel($db);

// Current datetime
$now = date('Y-m-d H:i:s');

// Update reservations where date/time has passed and status is Pending or Confirmed
$sql = "UPDATE reservations
        SET statusID = 3  -- Completed
        WHERE CONCAT(date, ' ', endTime) <= ?
          AND statusID IN (1,2)";  // Pending or Confirmed

$stmt = $db->prepare($sql);
$stmt->bind_param("s", $now);
$stmt->execute();

echo "Reservations updated.\n";
?>
