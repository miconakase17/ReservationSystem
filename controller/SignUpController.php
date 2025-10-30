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

    public function signUp(
    $lastname,
    $firstname,
    $middlename,
    $username,
    $phonenumber,
    $email,
    $password,
    $roleID = 2,             // default = Customer
    $redirectToAdmin = false // optional
) {
    session_start();

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $data = [
        'username'   => $username,
        'password'   => $hashedPassword,
        'roleID'     => $roleID, 
        'createdAt'  => date('Y-m-d H:i:s'),
        'lastUpdate' => date('Y-m-d H:i:s'),
    ];

    if ($this->userModel->createUsers($data)) {
        $userID = $this->userModel->findUsersByUsername($username)['userID'];

        $this->userDetailsModel->createDetails([
            'userID'     => $userID,
            'firstName'  => $firstname,
            'lastName'   => $lastname,
            'middleName' => $middlename,
            'phoneNumber'=> $phonenumber,
            'email'      => $email
        ]);

        if ($redirectToAdmin) {
            header("Location: http://localhost/ReservationSystem/admin-dashboard.html?signup=success");
        } else {
            header("Location: http://localhost/ReservationSystem/login.php?signup=success");
        }
        exit();
    } else {
        $_SESSION['popup_message'] = "Failed to create user account.";
        header("Location: ../views/signup.php");
        exit();
    }
}

}
?>
