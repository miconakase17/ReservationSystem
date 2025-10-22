<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ReservationsModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/UserDetailsModel.php';
require_once __DIR__ . '/../models/ReservationReceiptModel.php';
require_once __DIR__ . '/../models/PaymentsModel.php';
require_once __DIR__ . '/../models/RecordingOptionsModel.php';
require_once __DIR__ . '/../models/AdditionalsModel.php';
require_once __DIR__ . '/../models/RecordingPricesModel.php';

class ReservationController {
    private $db;
    private $reservationModel;
    private $userDetailsModel;
    private $userModel;
    private $paymentModel;
    private $reservationReceiptModel;
    private $recordingOptionsModel;
    private $additionalsModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->reservationModel = new ReservationsModel($this->db);
        $this->userDetailsModel = new UserDetailsModel($this->db);
        $this->userModel = new UserModel($this->db);
        $this->paymentModel = new PaymentsModel($this->db);
        $this->reservationReceiptModel = new ReservationReceiptModel($this->db);
        $this->recordingOptionsModel = new RecordingOptionsModel($this->db);
        $this->additionalsModel = new AdditionalsModel($this->db);
    }

    public function createReservation($data, $files = null) {
        // 1️⃣ Create Main Reservation
        $this->reservationModel->userID = $data['userID'];
        $this->reservationModel->bandName = $data['bandName'] ?? '';
        $this->reservationModel->serviceID = $data['serviceID'];
        $this->reservationModel->date = $data['date'];
        $this->reservationModel->startTime = $data['startTime'];
        $this->reservationModel->endTime = $data['endTime'];
        $this->reservationModel->statusID = 1; // Pending
        $this->reservationModel->totalCost = floatval(
            preg_replace('/[^\d.]/', '', $data['totalCost'])
        );

        // 2️⃣ Calculate total cost
        if ($data['serviceID'] == 2) {
        $pricesModel = new RecordingPricesModel($this->db);
        
        $modePrice = $pricesModel->getPriceByName($data['recordingMode']); // MultiTrack / LiveTrack
        $mixPrice = isset($data['mix']) ? $pricesModel->getPriceByName('MixAndMaster') : 0;

        $start = new DateTime($data['startTime']);
        $end = new DateTime($data['endTime']);
        $hours = max(1, ($end->getTimestamp() - $start->getTimestamp()) / 3600);

        $this->reservationModel->totalCost = ($modePrice * $hours) + $mixPrice;
} else {
}

        // ✅ createReservation() should return insert_id
        $reservationID = $this->reservationModel->createReservation();

        if ($reservationID) {

            // 2️⃣ If Recording, add recording options
            if ($data['serviceID'] == 2) {
                $recordingOptions = new RecordingOptionsModel($this->db);
                $recordingOptions->reservationID = $reservationID;
                $recordingOptions->mode = $data['recordingMode'] ?? 'MultiTrack';
                $recordingOptions->mixAndMaster = isset($data['mix']) ? 1 : 0;
                $recordingOptions->createRecordingOptions();
            }

            // 3️⃣ If Studio Rental, store additionals
            if ($data['serviceID'] == 1 && !empty($data['additionals'])) {
                $additionals = new AdditionalsModel($this->db);
                foreach ($data['additionals'] as $addItem) {
                    $additionals->linkToReservation($reservationID, $addItem);
                }
            }

            // 4️⃣ Upload receipt
            if ($files && isset($files['receipt']) && $files['receipt']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . basename($files['receipt']['name']);
                $targetPath = __DIR__ . '/../uploads/' . $fileName;

                if (move_uploaded_file($files['receipt']['tmp_name'], $targetPath)) {
                    $receiptModel = new ReservationReceiptModel($this->db);
                    $receiptModel->reservationID = $reservationID;
                    $receiptModel->uploadType = $data['upload_type'] ?? 'receipt';
                    $receiptModel->fileName = $fileName;
                    $receiptModel->createReceipt();
                }
            }

            // 5️⃣ Record Payment (Optional)
            if (!empty($data['amountPaid'])) {
                $paymentModel = new PaymentsModel($this->db);
                $paymentModel->userID = $data['userID'];
                $paymentModel->reservationID = $reservationID; // ✅ fixed: now not null
                $paymentModel->amount = floatval($data['amountPaid']);
                $paymentModel->paymentMethod = 'GCash';
                $paymentModel->paymentStatus = 'Pending';
                $paymentModel->paymentDate = date('Y-m-d H:i:s');
                $paymentModel->createPayments(); // ✅ removed ($data)
            }

            return ['success' => true, 'message' => 'Reservation created successfully.'];
        }

        return ['success' => false, 'message' => 'Failed to create reservation.'];
    }
}
?>
