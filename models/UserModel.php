<?php
class UserModel
{
    private $conn;
    private $table = "users";

    public $userID;
    public $username;
    public $password;
    public $roleID;
    public $createdAt;
    public $isActive;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ✅ Get all users
public function getAllUsers()
{
    $sql = "SELECT * FROM {$this->table} WHERE isActive = 1";
    $result = $this->conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


    // ✅ Get single user by ID
    public function getUsersById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Find user by username (used for login and signup verification)
    public function findUsersByUsername($username)
    {
        $sql = "SELECT u.userID, u.username, u.password, u.roleID, d.firstName, d.lastName
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
    public function createUsers($data)
    {
        $sql = "INSERT INTO {$this->table} (username, password, roleID, createdAt, isActive)
                VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssis", $data['username'], $data['password'], $data['roleID'], $data['createdAt']);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting into users: " . $stmt->error);
        }

        return true;
    }

    // Fetch latest 5 users with details
    public function getLatestUsers($limit = 5)
    {
        $sql = "SELECT u.userID, u.username, u.roleID, u.createdAt, u.isActive,
                    d.firstName, d.lastName
                FROM {$this->table} u
                LEFT JOIN user_details d ON u.userID = d.userID
                ORDER BY u.createdAt DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Count all users
    public function getUserCount()
    {
        $sql = "SELECT COUNT(*) AS totalUsers FROM {$this->table}";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['totalUsers'] ?? 0;
    }

    public function updateUser($userID, $data)
    {
        $sql = "UPDATE users SET username = ? WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data['username'], $userID);
        return $stmt->execute();
    }


}
?>