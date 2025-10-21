<?php
class UserDetailsModel {
    private $conn;
    private $table = "user_details";

    public $userID;
    public $lastName;
    public $firstName;
    public $middleName;
    public $phoneNumber;
    public $email;
    public $lastUpdate;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get user details by userID
    public function getByUserId($userID) {
        $query = "SELECT * FROM {$this->table} WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Create or update details
    public function createDetails($data) {
        $existing = $this->getByUserId($data['userID']);

        if ($existing) {
            // Update
            $sql = "UPDATE {$this->table} 
                    SET lastName = ?, firstName = ?, middleName = ?, 
                        phoneNumber = ?, email = ?, lastUpdate = NOW()
                    WHERE userID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "sssssi",
                $data['lastName'],
                $data['firstName'],
                $data['middleName'],
                $data['phoneNumber'],
                $data['email'],
                $data['userID']
            );
        } else {
            // Insert
            $sql = "INSERT INTO {$this->table} 
                    (userID, lastName, firstName, middleName, phoneNumber, email, lastUpdate) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "isssss",
                $data['userID'],
                $data['lastName'],
                $data['firstName'],
                $data['middleName'],
                $data['phoneNumber'],
                $data['email']
            );
        }

        return $stmt->execute();
    }
}
?>
