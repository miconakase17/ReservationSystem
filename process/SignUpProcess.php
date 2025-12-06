<?php
require_once __DIR__ . '/../controller/SignUpController.php';

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$username = $_POST['username'];
$phonenumber = $_POST['phonenumber'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];  // MATCHES your form name

$controller = new SignUpController();

$controller->signUp(
    $lastname,
    $firstname,
    $middlename,
    $username,
    $phonenumber,
    $email,
    $password,
    $confirmPassword   // MUST BE INCLUDED
);
