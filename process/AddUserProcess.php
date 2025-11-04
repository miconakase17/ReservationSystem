<?php
require_once __DIR__ . '/../controller/SignUpController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname    = $_POST['lastname'] ?? '';
    $firstname   = $_POST['firstname'] ?? '';
    $middlename  = $_POST['middlename'] ?? '';
    $username    = $_POST['username'] ?? '';
    $phonenumber = $_POST['phonenumber'] ?? '';
    $email       = $_POST['email'] ?? '';
    $password    = $_POST['password'] ?? '';

    $controller = new SignUpController();
    $controller->signUp(
        $lastname,
        $firstname,
        $middlename,
        $username,
        $phonenumber,
        $email,
        $password,
        1,      
        true    
    );
}
