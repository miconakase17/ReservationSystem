<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/UserDetailsModel.php';

class LoginController {
    private $db;
    private $userModel;
    private $userDetailsModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->userModel = new UserModel($this->db);
        $this->userDetailsModel = new UserDetailsModel($this->db);
    }

    public function login($username, $password) {
        session_start();

        $maxAttempts = 3;
        $lockoutTime = 300; // 5 minutes

        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
            $_SESSION['popup_message'] = "Too many login attempts. Try again later.";
            header("Location: ../login.php");
            exit();
        }

        $user = $this->userModel->findUsersByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                $_SESSION['lockout_time'] = time() + $lockoutTime;
                $_SESSION['popup_message'] = "Too many login attempts. Try again in 5 minutes.";
            } else {
                $remaining = $maxAttempts - $_SESSION['login_attempts'];
                $_SESSION['popup_message'] = "Invalid username or password. You have $remaining attempt(s) left.";
            }
            header("Location: ../login.php");
            exit();
        }

        // ✅ Successful login
        $_SESSION['login_attempts'] = 0;

        // 🟢 Fetch user details (name, email, phoneNumber)
        $details = $this->userDetailsModel->getUserDetailsByUserId($user['userID']);

        // 🟢 Store everything in session for use in profile
        $_SESSION['user'] = [
            'userID'      => $user['userID'],
            'username'    => $user['username'],
            'firstName'   => $details['firstName'] ?? '',
            'lastName'    => $details['lastName'] ?? '',
            'email'       => $details['email'] ?? '',
            'phoneNumber' => $details['phoneNumber'] ?? '',
            'roleID'      => $user['roleID'] ?? 2
        ];

        // 🟢 Redirect based on role
        if ($user['roleID'] == 1) {
            header("Location: http://localhost/ReservationSystem/admin-dashboard.html?login=success");
        } else {
            header("Location: http://localhost/ReservationSystem/customer-dashboard.php?login=success");
        }
        exit();
    }
}
?>
