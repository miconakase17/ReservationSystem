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

        // Validate Operating Hours (9 AM - 12 NN)
        $start = $data['startTime'];
        $end = $data['endTime'];

        if ($data['serviceID'] != 3) { // not Drum Lesson
            if ($start < "09:00" || $end > "23:59" || $start >= $end) {
                return [
                    'success' => false,
                    'message' => 'Operating hours are 9:00 AM to 12:00 Midnight only.'
                ];
            }
        }


        // Validate date
        if (empty($this->reservationModel->date)) {
            return ['success' => false, 'message' => 'Reservation date is required.'];
        }

        // Check for double booking for single reservations
        if ($data['serviceID'] != 3) { // Not Drum Lesson
            if (
                !$this->reservationModel->isTimeSlotAvailable(
                    $data['date'],
                    $data['startTime'],
                    $data['endTime']
                )
            ) {
                return ['success' => false, 'message' => 'Selected time slot conflicts with another reservation.'];
            }
        }


        // ---------------------------------------------------------------
// DRUM LESSON HANDLING (12 WEEKLY RESERVATIONS IN reservations TABLE)
// ---------------------------------------------------------------
        if ($data['serviceID'] == 3) {
            $startTime = $data['startTime'] ?? null;
            $endTime = $data['endTime'] ?? null;
            $reservationDate = $data['date'] ?? null;

            if (!$startTime || !$endTime || !$reservationDate) {
                return ['success' => false, 'message' => 'Start time, end time, and date are required for drum lessons.'];
            }

            // 1️⃣ Create main reservation
            $this->reservationModel->userID = $data['userID'];
            $this->reservationModel->serviceID = 3;
            $this->reservationModel->bandName = $data['bandName'] ?? '';
            $this->reservationModel->date = $reservationDate;
            $this->reservationModel->startTime = $startTime;
            $this->reservationModel->endTime = $endTime;
            $this->reservationModel->statusID = 1;
            $this->reservationModel->totalCost = floatval($data['totalCost'] ?? 0);

            $reservationID = $this->reservationModel->createReservation();
            if (!$reservationID) {
                return ['success' => false, 'message' => 'Failed to create drum lesson reservation.'];
            }

            // 2️⃣ Generate 12 weekly sessions
            $sessions = [];
            $startDate = new DateTime($reservationDate);
            for ($i = 0; $i < 12; $i++) {
                $sessionDate = clone $startDate;
                $sessionDate->modify("+$i week");
                $sessions[] = [
                    'date' => $sessionDate->format('Y-m-d'),
                    'startTime' => $startTime,
                    'endTime' => $endTime
                ];
            }

            // 3️⃣ Insert sessions with error checking
            foreach ($sessions as $session) {
                $this->drumLessonSessionsModel->reservationID = $reservationID;
                $this->drumLessonSessionsModel->date = $session['date'];
                $this->drumLessonSessionsModel->startTime = $session['startTime'];
                $this->drumLessonSessionsModel->endTime = $session['endTime'];

                if (!$this->drumLessonSessionsModel->createSession()) {
                    return ['success' => false, 'message' => "Failed to create session on {$session['date']}"];
                }
            }

            return ['success' => true, 'message' => 'Drum lesson reservation and all sessions created successfully.'];
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

    public function getUpcomingReservations()
    {
        return $this->reservationModel->getUpcomingReservations();
    }

}
?>