<?php

class Question {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getQuestionsByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE category = :category");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    
    
    public function saveAnswer($simulatorId, $studentId, $questionId, $answer) {
        $stmt = $this->db->prepare("
            INSERT INTO answers (simulator_id, student_id, question_id, answer)
            VALUES (:simulator_id, :student_id, :question_id, :answer)
        ");

        $stmt->bindParam(':simulator_id', $simulatorId, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to save the answer: " . implode(', ', $stmt->errorInfo()));
        }
    }
    
    
// $stmt = $this->db->prepare("
        //     INSERT INTO simulator (SimulatorID, StudentID, QuestionID, answer, feedback, score, Date)
        //     VALUES (:simulatorId, :studentId, :questionId, :answer, NULL, NULL, NOW())
        // ");
        // $stmt->bindParam(':simulatorId', $simulatorId);
        // $stmt->bindParam(':studentId', $studentId);
        // $stmt->bindParam(':questionId', $questionId);
        // $stmt->bindParam(':answer', $answer);
        // $stmt->execute();
    
}
?>
