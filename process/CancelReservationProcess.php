<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';

if (!isset($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "Missing ID"]);
    exit;
}

$id = intval($_POST['id']);
$conn = Database::getConnection();

$sql = "UPDATE reservations SET statusID = 3 WHERE reservationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Reservation cancelled successfully."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to cancel reservation."
    ]);
}
