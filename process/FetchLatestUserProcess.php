<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

try {
    $db = Database::getConnection();
    $userModel = new UserModel($db);

    // Fetch the latest 5 users
    $latestUsers = $userModel->getLatestUsers(5);
    error_log(print_r($latestUsers, true));

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'data' => $latestUsers
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
