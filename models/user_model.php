<?php

class User {
    private $conn;
    private $table = "users";

    public $userID;
    public $lastName;
    public $firstName;
    public $middleName;
    public $username;
    public $phoneNumber;
    public $email;
    public $password;
    public $roleID;
    public $statusID;
    public $createdAt;
    public $lastUpdate;
    public $isActive;

    public function __construct($db) {
        $this->conn = $db;
    }

    //  Get all users
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single user by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE userID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // LOGIN - Find user by username
     public function findByUsername($username) {
        $sql = "SELECT userID, firstName, lastName, password 
                FROM " . $this->table . " 
                WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // SIGN UP - Create new user
     public function create($data) {
        $sql = "INSERT INTO {$this->table} 
            (lastName, firstName, middleName, username, phoneNumber, email, password, createdAt, lastUpdate) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("sssssssss", 
            $data['lastName'],
            $data['firstName'],
            $data['middleName'],
            $data['username'],
            $data['phoneNumber'],
            $data['email'],
            $data['password'],
            $data['createdAt'],
            $data['lastUpdate']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            if ($stmt->errno === 1062) {
                throw new Exception("Username or email already exists.");
            }
            throw new Exception("Error: " . $stmt->error);
        }
    }
}

?>
