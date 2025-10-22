<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/AdditionalsModel.php';

$additionals = null;
$studioPricings = [];
$db = null;
try {
    $db = Database::getConnection();
    $additionalsModel = new AdditionalsModel($db);
    $additionals = $additionalsModel->readAllAdditionals();

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
