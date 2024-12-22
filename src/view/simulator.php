<?php
$db = new PDO('mysql:host=localhost;dbname=CareerCompass', 'root', '');
$studentId = 1; // Example, replace with the actual student ID
$simulatorId = null;

// Create a new simulator session
$query = "INSERT INTO simulator_sessions (studentId) VALUES (?)";
$stmt = $db->prepare($query);
$stmt->execute([$studentId]);
$simulatorId = $db->lastInsertId();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interview Simulator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            margin-top: 80px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .question-container {
            display: none;
            margin-bottom: 20px;
        }

        .question-container.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        .question {
            font-size: 1.2em;
            color: #444;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .answer-input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .nav-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: #eee;
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background-color: #007bff;
            transition: width 0.3s ease;
        }
        .submit-button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 20px;
        }

        .submit-button:hover {
            background-color: #218838;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            display: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    
</head>
<body>
<header>
        <nav class="navbar">
            <?php require_once __DIR__ . "/../../tests/Navbar2.php"; ?>
        </nav>
    </header>
    
    <div class="container">
        <h1>Interview Simulator</h1>
        
        <?php if (empty($questions)): ?>
            <p>No questions available for this category.</p>
            <a href="/" class="nav-button">Return to Categories</a>
        <?php else: ?>
            <div class="progress-bar">
                <div class="progress" id="progress"></div>
            </div>
            
            <div id="questions-container">
            <form action="../public/index.php?route=save-answer" method="POST">
                <input type="hidden" name="studentId" value="<?php echo $studentId; ?>">
                <input type="hidden" name="simulatorID" value="<?php echo $simulatorId; ?>">
                <input type="hidden" name="QuestionID" value="<?php echo $question['QuestionID']; ?>">

               <?php echo "<pre>";
print_r($questions);
echo "</pre>";
?>
                <?php foreach ($questions as $index => $question): ?>
    <div class="question-container <?php echo $index === 0 ? 'active' : ''; ?>">
        <div class="question">
            <?php echo htmlspecialchars($question['question'] ?? ''); ?>
        </div>
        <textarea class="answer-input" name="answers[<?php echo htmlspecialchars($question['QuestionID'] ?? ''); ?>]"
        placeholder="Type your answer here..."></textarea>
    </div>
<?php endforeach; ?>
                    <div class="button-container">
                        <button type="submit" class="submit-button">Submit All Answers</button>
                    </div>
                </form>
            </div>
            
            <div class="button-container">
                <button class="nav-button" id="prev-button" disabled>Previous</button>
                <button class="nav-button" id="next-button">Next</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const containers = document.querySelectorAll('.question-container');
            const prevButton = document.getElementById('prev-button');
            const nextButton = document.getElementById('next-button');
            const progressBar = document.getElementById('progress');
            let currentQuestion = 0;
            const totalQuestions = containers.length;

            function updateProgress() {
                const progress = ((currentQuestion + 1) / totalQuestions) * 100;
                progressBar.style.width = `${progress}%`;
            }

            function showQuestion(index) {
                containers.forEach(container => container.classList.remove('active'));
                containers[index].classList.add('active');
                
                prevButton.disabled = index === 0;
                nextButton.disabled = index === totalQuestions - 1;
                
                updateProgress();
            }

            

            // Navigation event listeners
            prevButton.addEventListener('click', () => {
                if (currentQuestion > 0) {
                    currentQuestion--;
                    showQuestion(currentQuestion);
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentQuestion < totalQuestions - 1) {
                    currentQuestion++;
                    showQuestion(currentQuestion);
                }
            });

            // Save answers as they're typed (with debouncing)
            // let saveTimeout;
            // document.querySelectorAll('.answer-input').forEach(textarea => {
            //     textarea.addEventListener('input', function() {
            //         clearTimeout(saveTimeout);
            //         const container = this.closest('.question-container');
            //         const questionId = container.dataset.questionId;
                    
            //         saveTimeout = setTimeout(() => {
            //             saveAnswer(questionId, this.value);
            //         }, 1000); // Wait 1 second after typing stops
            //     });
            // });

            // Initialize progress bar
            updateProgress();

            // // Store answers in localStorage as backup
            // function saveToLocalStorage(questionId, answer) {
            //     localStorage.setItem(`answer_${questionId}`, answer);
            // }

            // // Load any saved answers from localStorage
            // document.querySelectorAll('.answer-input').forEach(textarea => {
            //     const questionId = textarea.closest('.question-container').dataset.questionId;
            //     const savedAnswer = localStorage.getItem(`answer_${questionId}`);
            //     if (savedAnswer) {
            //         textarea.value = savedAnswer;
            //     }
            // });

            // // Add localStorage backup to input handler
            // document.querySelectorAll('.answer-input').forEach(textarea => {
            //     textarea.addEventListener('input', function() {
            //         const container = this.closest('.question-container');
            //         const questionId = container.dataset.questionId;
            //         saveToLocalStorage(questionId, this.value);
            //     });
            // });
        });
    </script>
</body>
</html>