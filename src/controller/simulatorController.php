<?php
require_once __DIR__ . '/../model/simulatorModel.php';


class QuestionController {
    private $questionModel;

    public function __construct($db) {
        $this->questionModel = new Question($db);
    }

    public function displayQuestions($category) {
        $questions = $this->questionModel->getQuestionsByCategory($category);
        require __DIR__ . '/../view/simulator.php';
    }

    public function saveAnswer($simulatorId,$studentId, $questionId, $answer) {
        $result = $this->questionModel->saveAnswer($simulatorId,$studentId, $questionId, $answer);
        if (!$result) {
            echo "Error saving the answer.";
        }
        
    }
    
    
    
    

    
}
?>
