<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Questions</title>
    <link rel="stylesheet" href="../../public/assets/styles/InterviewSimulator.css"> 
    <link rel="stylesheet" href="../../public/assets/styles/ResumeReview.css">
</head>
<body>
<div>
    <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
    </nav>
</div>
    <!-- Main content of the page -->
    <div class="profile-container">
        
        <div class="sidebar">
        <button class="back-button"> <a href="userDashboard.php"> ← </a></button>  
            <h2>Nour B</h2>
            <hr>
            <ul class="profile-links">
                <li><a href="bookCounselors.php" data-target="Book with our counselors">Book with our counselors</a></li>
                <li><a href="ResumeReview.php" data-target="Resume guide">Resume Guide</a></li>
                <li><a href="#" data-target="Discussions">Discussions</a></li>
            </ul>
            <hr>
            <div class="logout">
                <a href="#">Log out</a>
            </div>
        </div>
        <div class="Interview-content">
        <div class="container">
        
            <h1>Common Interview Questions</h1>
            <div class="progress">
                <span id="current-question">1</span>/<span id="total-questions">5</span>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            
        </div>
            <div class="question-container" id="question-container">
                <div class="question" id="question-text"></div>
                <textarea class="answer-input" id="answer-input" rows="4" placeholder="Type your answer here..."></textarea>
                <button class="next" id="next-button">Next Question</button>
            </div>
        </div>
    </div>



    <script src="../../public/assets/scripts/InterviewSimulator.js"></script>
</body>
</html>