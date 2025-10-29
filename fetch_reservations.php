<?php
header('Content-Type: application/json');
require_once 'config/database.php';

// ✅ Get connection from Database class
$conn = Database::getConnection();

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

if (!$start || !$end) {
    echo json_encode(['error' => 'Missing date range parameters']);
    exit;
}

$sql = "
    SELECT 
        reservationID,
        bandName,
        serviceID,
        date,
        startTime,
        endTime,
        totalCost,
        statusID
    FROM reservations
    WHERE date BETWEEN ? AND ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit;
}

$stmt->bind_param('ss', $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

echo json_encode($reservations);

$stmt->close();
$conn->close();
?>
