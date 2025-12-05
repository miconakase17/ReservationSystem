<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
$conn = Database::getConnection();

if (!isset($_POST['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Reservation ID missing."
    ]);
    exit;
}

$reservationID = intval($_POST['id']);

// Update the reservation status to Completed (statusID = 4)
$sql = "UPDATE reservations SET statusID = 4 WHERE reservationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservationID);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Reservation marked as Completed."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to mark reservation as Completed."
    ]);
}

$stmt->close();
$conn->close();
