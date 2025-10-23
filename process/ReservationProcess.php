<?php
session_start();
require_once __DIR__ . '/../controller/ReservationController.php';

// Make sure user is logged in
if (!isset($_SESSION['user']['userID'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in.']));
}

// Get userID directly from session (not from form)
$userID = $_SESSION['user']['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'userID' => (int)$userID, // ✅ always valid and from session
        'serviceID' => $_POST['serviceID'] ?? '',
        'bandName' => $_POST['bandName'] ?? '',
        'date' => $_POST['date'] ?? '',
        'startTime' => $_POST['startTime'] ?? '',
        'endTime' => $_POST['endTime'] ?? '',
        'totalCost' => $_POST['totalCost'] ?? '',
        'recordingMode' => $_POST['recordingMode'] ?? null,
        'mix' => $_POST['mix'] ?? null,
        'additionals' => $_POST['additionals'] ?? [],
        'amountPaid' => $_POST['amountPaid'] ?? null,
        'referenceNumber' => $_POST['referenceNumber'] ?? '',
        'upload_type' => $_POST['upload_type'] ?? 'receipt'
    ];

    $files = $_FILES ?? null;

    $controller = new ReservationController();
    $result = $controller->createReservation($data, $files);

    echo json_encode($result);
}
?>
