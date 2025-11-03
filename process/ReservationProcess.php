<?php
session_start();
require_once __DIR__ . '/../controller/ReservationController.php';

if (!isset($_SESSION['user']['userID'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in.']));
}

$userID = $_SESSION['user']['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Base data
    $data = [
        'userID' => (int) $userID,
        'serviceID' => $_POST['serviceID'] ?? '',
        'bandName' => $_POST['bandName'] ?? '',
        'totalCost' => $_POST['totalCost'] ?? '',
        'amountPaid' => $_POST['downPayment'] ?? null,
        'referenceNumber' => $_POST['referenceNumber'] ?? '',
        'recordingMode' => $_POST['recordingMode'] ?? null,
        'mix' => $_POST['mix'] ?? null,
        'additionals' => $_POST['additionals'] ?? [],
        'upload_type' => $_POST['upload_type'] ?? 'receipt',
        'date' => $_POST['date'] ?? '',
        'startTime' => $_POST['startTime'] ?? '',
        'endTime' => $_POST['endTime'] ?? ''
    ];

    // ✅ Generate weekly sessions for Drum Lesson
    if ($data['serviceID'] == 3) { // Drum Lesson
        $weeklySessions = [];
        $startDate = new DateTime($data['date']);
        $startTime = $data['startTime'];
        $endTime = $data['endTime'];

        for ($i = 0; $i < 12; $i++) {
            $sessionDate = clone $startDate;
            $sessionDate->modify("+$i week");
            $weeklySessions[] = [
                'date' => $sessionDate->format('Y-m-d'),
                'startTime' => $startTime,
                'endTime' => $endTime
            ];
        }
        $data['weeklySessions'] = $weeklySessions;
    }

    $files = $_FILES ?? null;

    $controller = new ReservationController();
    $result = $controller->createReservation($data, $files);

    echo json_encode($result);
}
?>
