<?php
// Correct require paths
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ServicePricingModel.php'; // make sure filename matches exactly

header('Content-Type: application/json');

try {
    if (!isset($_GET['serviceID'], $_GET['date'])) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit;
    }

    $serviceID = (int) $_GET['serviceID'];
    $date = $_GET['date'];

    $db = Database::getConnection(); // make sure database.php has getConnection()
    $pricingModel = new ServicePricingModel($db); // now the class should be found
    $rate = $pricingModel->getRateForDate($serviceID, $date);

    echo json_encode(['success' => true, 'rate' => (float)$rate]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
