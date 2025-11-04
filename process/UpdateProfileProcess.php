<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserDetailsModel.php';
require_once __DIR__ . '/../models/UserModel.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$db = Database::getConnection();
$userDetails = new UserDetailsModel($db);
$userModel = new UserModel($db);

$userID = $_SESSION['user']['userID'];
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$phoneNumber = trim($_POST['phoneNumber'] ?? '');

// Update user table (for email or username if applicable)
$userModel->updateUser($userID, [
    'username' => $username
]);


// Update user_details table
$updated = $userDetails->createDetails([
    'userID' => $userID,
    'firstName' => $firstName,
    'lastName' => $lastName,
    'middleName' => '',
    'phoneNumber' => $phoneNumber,
    'email' => $email
]);

if ($updated) {
    // Refresh session info
    $_SESSION['user']['firstName'] = $firstName;
    $_SESSION['user']['lastName'] = $lastName;
    $_SESSION['user']['phoneNumber'] = $phoneNumber;
    $_SESSION['user']['email'] = $email;

      // Redirect to customer dashboard
     echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Profile update failed.']);
}

?>
