<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../config/Database.php';

if (!isset($_POST['reservationID'])) {
    echo json_encode(["success" => false, "message" => "Missing reservation ID"]);
    exit;
}

$reservationID = intval($_POST['reservationID']);
$userID = intval($_SESSION['user']['userID']); // logged in customer

$conn = Database::getConnection();


// Make sure the user owns the reservation
$sql = "UPDATE reservations 
        SET statusID = 3 
        WHERE reservationID = ? AND userID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $reservationID, $userID);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode([
        "success" => true,
        "message" => "Reservation cancelled successfully."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Unable to cancel reservation."
    ]);
}
?>
