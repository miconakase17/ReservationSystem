<?php
// includes/reservation-data.php
// Responsible for preparing $additionals and $studioPricings for reservation pages.
// Does NOT start the session.

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/additionals-model.php';

$additionals = null;
$studioPricings = [];
$db = null;
try {
    $db = Database::connect();
    $additionalsModel = new Additionals($db);
    $additionals = $additionalsModel->readAll();

    $pricingSql = "SELECT sp.weekdayFrom, sp.weekdayTo, sp.hourlyRate FROM service_pricings sp JOIN services s ON sp.serviceID = s.serviceID WHERE s.serviceName = 'Studio Rental'";
    $pricingRes = $db->query($pricingSql);
    if ($pricingRes) {
        while ($r = $pricingRes->fetch_assoc()) {
            $studioPricings[] = $r;
        }
    }
} catch (Exception $ex) {
    // Fail gracefully: keep $additionals = null and $studioPricings empty
    $logDir = __DIR__ . '/../uploads/logs/';
    if (!is_dir($logDir)) mkdir($logDir, 0755, true);
    file_put_contents($logDir . 'reservation_include_errors.log', '['.date('Y-m-d H:i:s').'] reservation-data include error: '.$ex->getMessage()."\n", FILE_APPEND);
}
