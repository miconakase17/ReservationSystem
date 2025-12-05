<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

if (!isset($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "Missing ID"]);
    exit;
}

$id = intval($_POST['id']);
$conn = Database::getConnection();

$sql = "UPDATE reservations SET statusID = 2 WHERE reservationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Reservation approved successfully."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to approve reservation."
    ]);
}
