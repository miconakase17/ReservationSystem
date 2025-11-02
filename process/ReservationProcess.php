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

    // Base data
    $data = [
        'userID' => (int) $userID, // ✅ always valid and from session
        'serviceID' => $_POST['serviceID'] ?? '',
        'bandName' => $_POST['bandName'] ?? '',
        'totalCost' => $_POST['totalCost'] ?? '',
        'recordingMode' => $_POST['recordingMode'] ?? null,
        'mix' => $_POST['mix'] ?? null,
        'additionals' => $_POST['additionals'] ?? [],
        'upload_type' => $_POST['upload_type'] ?? 'receipt'
    ];

    // Handle payment fields depending on service type
    switch ($_POST['serviceID']) {
        case '1': // Studio Rental
            $data['amountPaid'] = $_POST['studioAmountPaid'] ?? null;
            $data['referenceNumber'] = $_POST['studioReferenceNumber'] ?? '';
            break;

        case '2': // Recording
            $data['amountPaid'] = $_POST['recordingAmountPaid'] ?? null;
            $data['referenceNumber'] = $_POST['recordingReferenceNumber'] ?? '';
            break;

        case '3': // Drum Lesson (no payment yet)
            $data['amountPaid'] = null;
            $data['referenceNumber'] = null;
            break;
    }


    // Handle date/time depending on selected service
    switch ($_POST['serviceID']) {
        case '1': // Studio Rental
            $data['date'] = $_POST['studioDate'] ?? '';
            $data['startTime'] = $_POST['studioStartTime'] ?? '';
            $data['endTime'] = $_POST['studioEndTime'] ?? '';
            break;

        case '2': // Recording
            $data['date'] = $_POST['recordingDate'] ?? '';
            $data['startTime'] = $_POST['recordingStartTime'] ?? '';
            $data['endTime'] = $_POST['recordingEndTime'] ?? '';
            break;

        case '3': // Drum Lesson
            $data['date'] = $_POST['drumDate'] ?? '';
            $data['startTime'] = $_POST['drumStartTime'] ?? '';
            $data['endTime'] = $_POST['drumEndTime'] ?? '';
            break;

        default:
            $data['date'] = '';
            $data['startTime'] = '';
            $data['endTime'] = '';
    }

    $files = $_FILES ?? null;

    $controller = new ReservationController();
    $result = $controller->createReservation($data, $files);

    echo json_encode($result);
}
?>