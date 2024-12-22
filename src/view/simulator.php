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
    <link rel="stylesheet" href="../../public/assets/styles/interviewsimulator.css">
    
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
            <form action="../config/index.php?route=save-answer" method="POST">
                <input type="hidden" name="studentId" value="<?php echo $studentId; ?>">
                <input type="hidden" name="simulatorID" value="<?php echo $simulatorId; ?>">

                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-container <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="question">
                            <?php echo htmlspecialchars($question['question'] ?? ''); ?>
                        </div>
                        <textarea class="answer-input" name="answers[<?php echo htmlspecialchars($question['QuestionID'] ?? ''); ?>]"
                                  placeholder="Type your answer here..."></textarea>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="button-container submit-button" id="submit-button">Submit All Answers</button>
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
        const submitButton = document.getElementById('submit-button');
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
            nextButton.style.display = index === totalQuestions - 1 ? 'none' : 'block';
            submitButton.style.display = index === totalQuestions - 1 ? 'block' : 'none';

            updateProgress();
        }

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

        updateProgress();
    });
</script>
</body>
</html>

    <script src="../../public/assets/scripts/InterviewSimulator.js"></script>
</body>
</html>