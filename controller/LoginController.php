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

        // Initialize login attempt counter
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        $maxAttempts = 3;
        $lockoutTime = 300; // 5 minutes

        // Lockout logic
        if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
            $_SESSION['popup_message'] = "Too many login attempts. Try again later.";
            header("Location: ../login.php");
            exit();
        }

        $user = $this->userModel->findUsersByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
        // Fetch user details from user_details table
        $details = $this->userDetailsModel->getUserDetailsByUserId($user['userID']);

        // Successful login
        $_SESSION['login_attempts'] = 0;
        $_SESSION['user'] = [
            'userID' => $user['userID'],
            'firstName' => $details['firstName'] ?? '',
            'lastName' => $details['lastName'] ?? '',
            'username' => $user['username']
        ];

        header("Location: http://localhost/ReservationSystem/customer-dashboard.php?login=success");
        exit();
    } else {
        // Failed login
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            $_SESSION['lockout_time'] = time() + $lockoutTime;
            $_SESSION['popup_message'] = "Too many login attempts. Please try again in 5 minutes.";
        } else {
            $remaining = $maxAttempts - $_SESSION['login_attempts'];
            $_SESSION['popup_message'] = "Invalid username or password. You have $remaining attempt(s) left.";
        }

        header("Location: ../login.php");
        exit();
    }

     // Find user by username
        $user = $this->userModel->findUsersByUsername($username);

        // 🔹 CASE 1: Wrong username
        if (!$user) {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                $_SESSION['lockout_time'] = time() + $lockoutTime;
                $_SESSION['popup_message'] = "Too many login attempts. Please try again in 5 minutes.";
            } else {
                $remaining = $maxAttempts - $_SESSION['login_attempts'];
                $_SESSION['popup_message'] = "Wrong username. You have $remaining attempt(s) left.";
            }
            header("Location: ../login.php");
            exit();
        }

        // 🔹 CASE 2: Wrong password
        if (!password_verify($password, $user['password'])) {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                $_SESSION['lockout_time'] = time() + $lockoutTime;
                $_SESSION['popup_message'] = "Too many login attempts. Please try again in 5 minutes.";
            } else {
                $remaining = $maxAttempts - $_SESSION['login_attempts'];
                $_SESSION['popup_message'] = "Wrong password. You have $remaining attempt(s) left.";
            }
            header("Location: ../login.php");
            exit();
        }

        // 🔹 CASE 3: Successful login
        $_SESSION['login_attempts'] = 0;

        // Fetch details from user_details
        $details = $this->userDetailsModel->getUserDetailsByUserId($user['userID']);

        $_SESSION['user'] = [
            'userID' => $user['userID'],
            'firstName' => $details['firstName'] ?? '',
            'lastName' => $details['lastName'] ?? '',
            'username' => $user['username']
        ];

        header("Location: http://localhost/ReservationSystem/customer-dashboard.php?login=success");
        exit();
    }
    
}
?>
