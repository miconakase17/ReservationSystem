<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Method to fetch latest users
    public function fetchLatestUsers($limit = 5) {
        try {
            $latestUsers = $this->userModel->getLatestUsers($limit);

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
    }
}
