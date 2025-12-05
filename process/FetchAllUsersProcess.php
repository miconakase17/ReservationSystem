<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/UserDetailsModel.php';

try {
    $db = Database::getConnection();
    $userModel = new UserModel($db);
    $userDetailsModel = new UserDetailsModel($db);

    $usersRaw = $userModel->getAllUsers(); // Fetch all users
    $users = [];

    foreach ($usersRaw as $user) {
        $details = $userDetailsModel->getUserDetailsByUserId($user['userID']);
        $users[] = [
            'id' => $user['userID'],
            'username' => $user['username'],
            'role' => $user['roleID'],
            'name' => $details ? $details['firstName'] . ' ' . $details['lastName'] : '',
            'email' => $details['email'] ?? '',
            'phoneNumber' => $details['phoneNumber'] ?? ''
        ];
    }

    $totalUsers = count($users);

} catch (Exception $e) {
    $users = [];
    $totalUsers = 0;
}