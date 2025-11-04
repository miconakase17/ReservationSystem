<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ReservationsModel.php';
require_once __DIR__ . '/../models/RecordingOptionsModel.php';
require_once __DIR__ . '/../models/AdditionalsModel.php';
require_once __DIR__ . '/../models/ReservationReceiptModel.php';
require_once __DIR__ . '/../models/PaymentsModel.php';
require_once __DIR__ . '/../models/RecordingPricesModel.php';
require_once __DIR__ . '/../models/DrumLessonSessionsModel.php';

class ReservationController
{
    private $db;
    private $reservationModel;
    private $drumLessonSessionsModel;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->reservationModel = new ReservationsModel($this->db);
        $this->drumLessonSessionsModel = new DrumLessonSessionsModel($this->db);
    }

    public function createReservation($data, $files = null)
    {
        // 1️⃣ Assign general reservation fields
        $this->reservationModel->userID = $data['userID'];
        $this->reservationModel->serviceID = $data['serviceID'];
        $this->reservationModel->bandName = $data['bandName'] ?? '';
        $this->reservationModel->statusID = 1; // Pending
        $this->reservationModel->date = $data['date'] ?? '';
        $this->reservationModel->startTime = $data['startTime'] ?? '';
        $this->reservationModel->endTime = $data['endTime'] ?? '';
        $this->reservationModel->totalCost = floatval(preg_replace('/[^\d.]/', '', $data['totalCost'] ?? '0'));


        // Validate date
        if (empty($this->reservationModel->date)) {
            return ['success' => false, 'message' => 'Reservation date is required.'];
        }

        // Check for double booking for single reservations
        if ($data['serviceID'] != 3) { // Not Drum Lesson
            if (
                !$this->reservationModel->isTimeSlotAvailable(
                    $data['serviceID'],
                    $data['date'],
                    $data['startTime'],
                    $data['endTime']
                )
            ) {
                return ['success' => false, 'message' => 'Selected time slot is already booked.'];
            }
        }

        // Check for Drum Lesson weekly sessions
        if ($data['serviceID'] == 3 && !empty($data['weeklySessions'])) {
            foreach ($data['weeklySessions'] as $session) {
                if (
                    !$this->reservationModel->isTimeSlotAvailable(
                        $data['serviceID'],
                        $session['date'],
                        $session['startTime'],
                        $session['endTime']
                    )
                ) {
                    return [
                        'success' => false,
                        'message' => 'One or more drum lesson sessions conflict with existing bookings.'
                    ];
                }
            }
        }

        // 2️⃣ Create reservation record
        $reservationID = $this->reservationModel->createReservation();
        if (!$reservationID) {
            return ['success' => false, 'message' => 'Failed to create reservation.'];
        }
        // ✅ 3️⃣ Drum Lesson Weekly Sessions
        if ($data['serviceID'] == 3 && !empty($data['weeklySessions'])) {
            $this->drumLessonSessionsModel->createMultipleSessions($reservationID, $data['weeklySessions']);
        }

        // 3️⃣ Recording options (for Recording service)
        if ($data['serviceID'] == 2) {
            $recordingOptions = new RecordingOptionsModel($this->db);
            $recordingOptions->reservationID = $reservationID;
            $recordingOptions->mode = $data['recordingMode'] ?? 'MultiTrack';
            $recordingOptions->mixAndMaster = isset($data['mix']) ? 1 : 0;
            $recordingOptions->createRecordingOptions();
        }

        // 4️⃣ Additionals (for Studio Rental)
        if ($data['serviceID'] == 1 && !empty($data['additionals'])) {
            $additionals = new AdditionalsModel($this->db);
            foreach ($data['additionals'] as $addItem) {
                $additionals->linkToReservation($reservationID, $addItem);
            }
        }

        // 5️⃣ Upload receipt (optional)
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

        // 6️⃣ Record payment (optional)
        if (!empty($data['amountPaid'])) {
            $paymentModel = new PaymentsModel($this->db);
            $paymentModel->userID = $data['userID'];
            $paymentModel->reservationID = $reservationID;
            $paymentModel->amount = floatval($data['amountPaid']);
            $paymentModel->paymentMethod = 'GCash';
            $paymentModel->paymentStatus = 'Pending';
            $paymentModel->paymentDate = date('Y-m-d H:i:s');
            $paymentModel->transactionReference = $data['referenceNumber'] ?? '';
            $paymentModel->createPayments();
        }

        return ['success' => true, 'message' => 'Reservation created successfully.'];
    }
}
?>