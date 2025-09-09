<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'];
    $bandName = $_POST['band_name'];
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $service = $_POST['service'];

    $conn = new mysqli('localhost', 'root', '', 'reservation_system');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details
    $stmt = $conn->prepare("SELECT firstName, lastName FROM users WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName);
    $stmt->fetch();
    $stmt->close();

    $details = ['reference_no' => null, 'amount' => null];
    $newFileName = null;

    // Handle receipt upload
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/receipts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['receipt']['tmp_name'];
        $fileName = $_FILES['receipt']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('receipt_', true) . '.' . $fileExtension;
        $receiptPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $receiptPath)) {
            die("Error uploading the receipt.");
        }

        // OCR Processing
        require '../vendor/autoload.php';   

        $ocr = new thiagoalessio\TesseractOCR\TesseractOCR($receiptPath);
        $text = $ocr->run();

        $details = extractGCashDetails($text);

    }

    // Insert reservation
    $stmt = $conn->prepare("INSERT INTO reservations 
        (userID, firstName, lastName, bandName, date, startTime, endTime, service, receiptPath, referenceNo, amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "issssssssss",
        $userID,
        $firstName,
        $lastName,
        $bandName,
        $date,
        $startTime,
        $endTime,
        $service,
        $newFileName,  // Save filename only, adjust if you want full path
        $details['reference_no'],
        $details['amount']
    );

    if ($stmt->execute()) {
        header("Location: ../customer_dashboard.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Function outside POST block
function extractGCashDetails($text) {
    $details = [];

    if (preg_match('/Reference No:\s*(\w+)/i', $text, $matches)) {
        $details['reference_no'] = $matches[1];
    }

    if (preg_match('/Amount:\s*PHP\s*([\d,]+\.\d{2})/i', $text, $matches)) {
        $details['amount'] = $matches[1];
    }

    return $details; 
}
?>
