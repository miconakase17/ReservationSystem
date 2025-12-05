<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

try {
    if (!isset($_POST['userID'])) {
        throw new Exception("User ID is required");
    }

    $db = Database::getConnection();
    $userModel = new UserModel($db);

    $userID = (int) $_POST['userID'];
    $sql = "UPDATE users SET isActive = 0 WHERE userID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
