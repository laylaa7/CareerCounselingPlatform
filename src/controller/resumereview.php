<?php
require_once __DIR__ . '/../model/resumereviewmodel.php';

class ResumeController {
    private $db;
    private $resume;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->resume = new Resume($this->db);
    }
    
    public function uploadWithoutSession($student_id, $file) {
        $this->resume->student_id = $student_id;
        if ($this->resume->upload($file)) {
            header("Location: dashboard.php?msg=success");
        } else {
            header("Location: dashboard.php?msg=error");
        }
    }
    
    public function listPending() {
        return $this->resume->getAllPending();
    }
}

// Controllers/ReviewController.php
class ReviewController {
    private $db;
    private $review;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->review = new Review($this->db);
    }
    
    public function submitReviewWithoutSession($resume_id, $counselor_id, $feedback) {
        if ($this->review->create($resume_id, $counselor_id, $feedback)) {
            header("Location: dashboard.php?msg=review_submitted");
        } else {
            header("Location: dashboard.php?msg=review_error");
        }
    }
}
?>