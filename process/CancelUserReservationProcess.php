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

// Optional: check that reservation exists and belongs to user
$sqlCheck = "SELECT serviceID FROM reservations WHERE reservationID = ? AND userID = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $reservationID, $userID);
$stmtCheck->execute();
$reservation = $stmtCheck->get_result()->fetch_assoc();

if (!$reservation) {
    echo json_encode(["success" => false, "message" => "Reservation not found."]);
    exit;
}

// Cancel the main reservation (this automatically cancels all linked sessions)
$sql = "UPDATE reservations SET statusID = 3 WHERE reservationID = ? AND userID = ?";
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
