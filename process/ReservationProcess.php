<?php
require_once __DIR__ . '/../controller/ReservationController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'userID' => $_POST['userID'] ?? '',
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
        'upload_type' => $_POST['upload_type'] ?? 'receipt'
    ];

    $files = $_FILES ?? null;

    $controller = new ReservationController();
    $result = $controller->createReservation($data, $files);

    // Optional: return JSON response
    echo json_encode($result);
}
