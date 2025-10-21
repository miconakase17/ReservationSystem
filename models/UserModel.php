<?php
class UserModel {
    private $conn;
    private $table = "users";

    public $userID;
    public $username;
    public $password;
    public $createdAt;
    public $isActive;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Get all users
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Get single user by ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Find user by username (used for login and signup verification)
    public function findByUsername($username) {
        $sql = "SELECT u.userID, u.username, u.password, d.firstName, d.lastName
                FROM {$this->table} u
                LEFT JOIN user_details d ON u.userID = d.userID
                WHERE u.username = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Create new user (signup)
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, password, createdAt, isActive)
                VALUES (?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $data['username'], $data['password'], $data['createdAt']);
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting into users: " . $stmt->error);
        }

        return true;
    }
}
?>
