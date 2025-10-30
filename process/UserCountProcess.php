<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

$db = Database::getConnection();
$userModel = new UserModel($db);

$totalUsers = $userModel->getUserCount();

// Return JSON
header('Content-Type: application/json');
echo json_encode(['totalUsers' => $totalUsers]);
