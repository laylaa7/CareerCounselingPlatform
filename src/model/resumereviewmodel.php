<?php
require_once __DIR__ . '/../config/Database.php';

class Resume {
    private $conn;
    private $table = "resumes";
    
    public $id;
    public $student_id;
    public $file_path;
    public $status;
    public $error;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function upload($file, $student_id) {
        // Validate student exists in students table
        if (!$this->validateStudent($student_id)) {
            $this->error = "Invalid student ID";
            return false;
        }
        
        $this->student_id = $student_id;
        $target_dir = "uploads/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = time() . '_' . basename($file["name"]);
        $target_file = $target_dir . $file_name;
        
        if ($file["type"] !== "application/pdf") {
            $this->error = "Only PDF files are allowed";
            return false;
        }
        
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $query = "INSERT INTO " . $this->table . " 
                    (student_id, file_path, status, uploaded_at) 
                    VALUES (:student_id, :file_path, 'pending', NOW())";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":student_id", $this->student_id);
            $stmt->bindParam(":file_path", $target_file);
            
            try {
                return $stmt->execute();
            } catch (PDOException $e) {
                $this->error = "Database error: " . $e->getMessage();
                return false;
            }
        }
        
        $this->error = "Error uploading file";
        return false;
    }
    
    public function getAllPending() {
        // Join with students table to get detailed student information
        $query = "SELECT r.*, 
                        s.StudentID, s.phone, s.Degree, s.major, s.university,
                        s.Grad_year, s.location as student_location
                FROM " . $this->table . " r
                JOIN students s ON r.student_id = s.UserID
                WHERE r.status = 'pending'
                ORDER BY r.uploaded_at DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->error = "Database error: " . $e->getMessage();
            return false;
        }
    }
    
    private function validateStudent($student_id) {
        $query = "SELECT UserID FROM students WHERE UserID = :student_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    public function getStudentResumes($student_id) {
        // Get resume history with counselor details
        $query = "SELECT r.*, 
                        COALESCE(rev.feedback, 'Not reviewed yet') as feedback,
                        c.CounselorID, c.position, c.specialization,
                        c.location as counselor_location
                FROM " . $this->table . " r
                LEFT JOIN reviews rev ON r.id = rev.resume_id
                LEFT JOIN counselors c ON rev.counselor_id = c.UserID
                WHERE r.student_id = :student_id
                ORDER BY r.uploaded_at DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":student_id", $student_id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->error = "Database error: " . $e->getMessage();
            return false;
        }
    }
}

class Review {
    private $conn;
    private $table = "reviews";
    public $error;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create($resume_id, $counselor_id, $feedback) {
        // Validate counselor exists and is verified
        if (!$this->validateCounselor($counselor_id)) {
            $this->error = "Invalid counselor ID or counselor not verified";
            return false;
        }
        
        // Validate resume exists and is pending
        if (!$this->validateResume($resume_id)) {
            $this->error = "Invalid resume ID or resume already reviewed";
            return false;
        }
        
        $this->conn->beginTransaction();
        
        try {
            // Insert review
            $query = "INSERT INTO " . $this->table . " 
                    (resume_id, counselor_id, feedback, created_at) 
                    VALUES (:resume_id, :counselor_id, :feedback, NOW())";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":resume_id", $resume_id);
            $stmt->bindParam(":counselor_id", $counselor_id);
            $stmt->bindParam(":feedback", $feedback);
            $stmt->execute();
            
            // Update resume status
            $query = "UPDATE resumes 
                    SET status='reviewed', 
                        reviewed_at=NOW() 
                    WHERE id=:resume_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":resume_id", $resume_id);
            $stmt->execute();
            
            // Update counselor's connection count
            $query = "UPDATE counselors 
                    SET No_of_Connections = No_of_Connections + 1 
                    WHERE UserID = :counselor_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":counselor_id", $counselor_id);
            $stmt->execute();
            
            $this->conn->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->conn->rollBack();
            $this->error = "Database error: " . $e->getMessage();
            return false;
        }
    }
    
    private function validateCounselor($counselor_id) {
        $query = "SELECT UserID FROM counselors 
                WHERE UserID = :counselor_id 
                AND verified = 1 
                AND status = 'active'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":counselor_id", $counselor_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    private function validateResume($resume_id) {
        $query = "SELECT id FROM resumes 
                WHERE id = :resume_id AND status = 'pending'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":resume_id", $resume_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    public function getCounselorReviews($counselor_id) {
        // Get reviews with detailed student information
        $query = "SELECT rev.*, r.file_path,
                        s.StudentID, s.Degree, s.major, s.university,
                        s.Grad_year, s.location as student_location
                FROM " . $this->table . " rev
                JOIN resumes r ON rev.resume_id = r.id
                JOIN students s ON r.student_id = s.UserID
                WHERE rev.counselor_id = :counselor_id
                ORDER BY rev.created_at DESC";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":counselor_id", $counselor_id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->error = "Database error: " . $e->getMessage();
            return false;
        }
    }
}