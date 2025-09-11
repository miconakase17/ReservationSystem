<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::connect(); // central DB class
    $user = new User($db);

    $data = [
        'lastName'   => $_POST['lastname'],
        'firstName'  => $_POST['firstname'],
        'middleName' => $_POST['middlename'],
        'username'   => $_POST['username'],
        'phoneNumber'=> $_POST['phonenumber'],
        'email'      => $_POST['email'],
        'password'   => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'createdAt'  => date('Y-m-d H:i:s'),
        'lastUpdate' => date('Y-m-d H:i:s'),
    ];

    try {
        if ($user->create($data)) {
            header("Location: http://localhost/ReservationSystem/login.html?signup=success");
            exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
