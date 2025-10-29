<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/UserDetailsModel.php';

class SignUpController {
    private $db;
    private $userModel;
    private $userDetailsModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->userModel = new UserModel($this->db);
        $this->userDetailsModel = new UserDetailsModel($this->db);
    }

    public function signUp($lastname, $firstname, $middlename, $username, $phonenumber, $email, $password) {
        session_start();

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $roleID = 2;
        $data = [
            'username' => $username,
            'password' => $hashedPassword,
            'roleID'   => $roleID,
            'createdAt' => date('Y-m-d H:i:s'),
            'lastUpdate' => date('Y-m-d H:i:s'),
        ];
        // Step 1: Create the user
        if ($this->userModel->createUsers($data)) {
            // Step 2: Retrieve the new user ID
            $user = $this->userModel->findUsersByUsername($username);
            $userID = $user['userID'];

            // Step 3: Insert user details
            $this->userDetailsModel->createDetails([
                'userID'      => $userID,
                'firstName'   => $firstname,
                'lastName'    => $lastname,
                'middleName'  => $middlename,
                'phoneNumber' => $phonenumber,
                'email'       => $email
            ]);

            // Step 4: Redirect
            header("Location: http://localhost/ReservationSystem/login.html?signup=success");
            exit();
        } else {
            $_SESSION['popup_message'] = "Failed to create user account.";
            header("Location: ../views/signup.php");
            exit();
        }
    }
}
?>
