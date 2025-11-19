<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/AdditionalsModel.php';
require_once __DIR__ . '/../models/RecordingPricesModel.php';
require_once __DIR__ . '/../models/ServicePricingModel.php';

$additionals = null;
$studioPricings = [];
$recordingPricings = [];
$db = null;

try {
    // 1️⃣ Initialize DB
    $db = Database::getConnection();

    // 2️⃣ Fetch additionals for Studio Rental
    $additionalsModel = new AdditionalsModel($db);
    $additionals = $additionalsModel->readAllAdditionals();

    // 3️⃣ Fetch Studio Rental pricing via ServicePricingModel
    $pricingModel = new ServicePricingModel($db);
    $studioPricings = $pricingModel->getPricingByServiceID(1); // 1 = Studio Rental

    // 4️⃣ Fetch Recording prices via RecordingPricesModel
    $recordingModel = new RecordingPricesModel($db);
    $recordingPricings = $recordingModel->getAllOptions();

} catch (Exception $ex) {
    $logDir = __DIR__ . '/../uploads/logs/';
    if (!is_dir($logDir))
        mkdir($logDir, 0755, true);
    file_put_contents(
        $logDir . 'reservation_include_errors.log',
        '[' . date('Y-m-d H:i:s') . '] reservation-data include error: ' . $ex->getMessage() . "\n",
        FILE_APPEND
    );
}
?>