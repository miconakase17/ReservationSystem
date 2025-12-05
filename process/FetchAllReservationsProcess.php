<?php
require_once __DIR__ . '/../config/database.php';

$conn = Database::getConnection();

// Load receipt model
require_once __DIR__ . '/../models/ReservationReceiptModel.php';
$receiptModel = new ReservationReceiptModel($conn);

$reservations = [];

/*
|----------------------------------------------------------------------
| 1. MAIN Reservations
|----------------------------------------------------------------------
*/

$sql = "
    SELECT 
        r.reservationID AS id,
        CONCAT(ud.firstName, ' ', ud.lastName) AS customer,
        r.bandName,
        s.serviceName AS serviceType,
        r.date,
        r.startTime,
        r.endTime,
        r.totalCost AS amountPaid,
        p.transactionReference AS referenceNumber,
        r.createdAt,
        st.statusName AS status
    FROM reservations r
    LEFT JOIN user_details ud ON ud.userID = r.userID
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    LEFT JOIN payments p ON p.reservationID = r.reservationID
    ORDER BY r.date DESC, r.startTime ASC
";


$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['isSession'] = 0; // normal reservation
        $reservations[] = $row;
    }
}

/*
|----------------------------------------------------------------------
| 2. Drum Lesson Weekly Sessions
|----------------------------------------------------------------------
*/

$sqlWeekly = "
    SELECT 
        d.sessionID AS id,
        CONCAT(ud.firstName, ' ', ud.lastName) AS customer,
        r.bandName,
        s.serviceName AS serviceType,
        d.date,
        d.startTime,
        d.endTime,
        r.totalCost AS amountPaid,
        p.transactionReference AS referenceNumber, 
        r.createdAt,   
        st.statusName AS status
    FROM drumlesson_sessions d
    INNER JOIN reservations r ON d.reservationID = r.reservationID
    LEFT JOIN user_details ud ON ud.userID = r.userID
    LEFT JOIN services s ON r.serviceID = s.serviceID
    LEFT JOIN status st ON r.statusID = st.statusID
    LEFT JOIN payments p ON p.reservationID = r.reservationID  
    ORDER BY d.date DESC, d.startTime ASC
";

$resultWeekly = $conn->query($sqlWeekly);

if ($resultWeekly) {
    while ($row = $resultWeekly->fetch_assoc()) {
        $row['isSession'] = 1; // drum lesson session
        $reservations[] = $row;
    }
}

/*
|----------------------------------------------------------------------
| 3. Attach Receipts to Each Reservation
|----------------------------------------------------------------------
*/

foreach ($reservations as $index => $row) {

    $reservationID = $row['id']; // both normal & session use 'id'

    // Fetch associated receipts
    $receipts = $receiptModel->getReceiptByReservationId($reservationID);

    // Attach receipts
    $reservations[$index]['receipts'] = $receipts;
}

$conn->close();

$totalReservations = count($reservations);
?>