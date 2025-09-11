<?php
class UserDetail {
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

    // Get user details
    public function getByUserId($userID) {
        $query = "SELECT * FROM {$this->table} WHERE userID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create or update details
    public function save($data) {
        $existing = $this->getByUserId($data['userID']);
        if ($existing) {
            $sql = "UPDATE {$this->table} 
                    SET lastName=:lastName, firstName=:firstName, middleName=:middleName, 
                        phoneNumber=:phoneNumber, email=:email, lastUpdate=NOW()
                    WHERE userID=:userID";
        } else {
            $sql = "INSERT INTO {$this->table} 
                    (userID, lastName, firstName, middleName, phoneNumber, email, lastUpdate) 
                    VALUES (:userID, :lastName, :firstName, :middleName, :phoneNumber, :email, NOW())";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":userID", $data['userID'], PDO::PARAM_INT);
        $stmt->bindParam(":lastName", $data['lastName']);
        $stmt->bindParam(":firstName", $data['firstName']);
        $stmt->bindParam(":middleName", $data['middleName']);
        $stmt->bindParam(":phoneNumber", $data['phoneNumber']);
        $stmt->bindParam(":email", $data['email']);
        return $stmt->execute();
    }
}
?>
