<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

try {
    if (!isset($_POST['userID'], $_POST['username'], $_POST['roleID'])) {
        throw new Exception("Required data missing");
    }

    $db = Database::getConnection();
    $userModel = new UserModel($db);

    $userID = (int) $_POST['userID'];
    $data = [
        'username' => $_POST['username'],
        'roleID' => (int) $_POST['roleID']
    ];

    $sql = "UPDATE users SET username = ?, roleID = ? WHERE userID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sii", $data['username'], $data['roleID'], $userID);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
