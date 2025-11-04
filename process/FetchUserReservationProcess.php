<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../config/Database.php';

// ✅ Ensure the user is logged in
if (!isset($_SESSION['user']['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userID = $_SESSION['user']['userID'];
$conn = Database::getConnection();
$today = date('Y-m-d');

$reservations = [];

// 🟢 Fetch all upcoming reservations for this user
$sql = "
    SELECT 
        r.reservationID,
        r.serviceID,
        s.serviceName,
        r.date,
        r.startTime,
        r.endTime,
        r.totalCost,
        st.statusName
    FROM reservations r
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    WHERE r.userID = ? AND r.date >= ?
    ORDER BY r.date ASC, r.startTime ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $userID, $today);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}
$stmt->close();

// 🟣 Include Drum Lesson Sessions if applicable
$sqlWeekly = "
    SELECT 
        d.sessionID,
        r.reservationID,
        r.serviceID,
        s.serviceName,
        d.date,
        d.startTime,
        d.endTime,
        r.totalCost,
        st.statusName
    FROM drumlesson_sessions d
    INNER JOIN reservations r ON d.reservationID = r.reservationID
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    WHERE r.userID = ? AND d.date >= ?
    ORDER BY d.date ASC, d.startTime ASC
";

$stmtWeekly = $conn->prepare($sqlWeekly);
$stmtWeekly->bind_param('is', $userID, $today);
$stmtWeekly->execute();
$resultWeekly = $stmtWeekly->get_result();

while ($row = $resultWeekly->fetch_assoc()) {
    $reservations[] = $row;
}

$stmtWeekly->close();
$conn->close();

// ✅ Return data as JSON
echo json_encode([
    'success' => true,
    'data' => $reservations
]);
?>
