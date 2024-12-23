<?php

require_once __DIR__ . '../../config/Database.php';

class Admin {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Fetch dashboard stats
    public function getDashboardStats() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    (SELECT COUNT(*) FROM users WHERE User_Role = 1) AS counselors,
                    (SELECT COUNT(*) FROM users WHERE User_Role = 0) AS users
            ");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching dashboard stats: " . $e->getMessage());
            return false;
        }
    }

    // Fetch all counselors
    public function getAllCounselors() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE User_Role = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching counselors: " . $e->getMessage());
            return false;
        }
    }

    // Fetch all users
    public function getAllUsers() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE User_Role = 0");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return false;
        }
    }
    public function getCounselors() {
        $sql = "SELECT * FROM counselors";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addCounselor($data) {
        $sql = "INSERT INTO counselors (UserID, position, specialization, location, verified, status, No_of_Connections) 
                VALUES (:UserID, :position, :specialization, :location, :verified, :status, :No_of_Connections)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateCounselor($id, $data) {
        $sql = "UPDATE counselors SET 
                    position = :position, 
                    specialization = :specialization, 
                    location = :location, 
                    verified = :verified, 
                    status = :status, 
                    No_of_Connections = :No_of_Connections 
                WHERE CounselorID = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteCounselor($id) {
        $sql = "DELETE FROM counselors WHERE CounselorID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public function getStudents() {
        $sql = "SELECT * FROM students";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addStudent($data) {
        $sql = "INSERT INTO students (UserID, fullName, email, role) 
                VALUES (:UserID, :fullName, :email, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateStudent($id, $data) {
        $sql = "UPDATE students SET 
                    fullName = :fullName, 
                    email = :email, 
                    role = :role 
                WHERE UserID = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteStudent($id) {
        $sql = "DELETE FROM students WHERE UserID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
 
}