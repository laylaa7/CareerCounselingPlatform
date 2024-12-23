<?php
$db = new PDO('mysql:host=localhost;dbname=CareerCompass', 'root', '');

try {
    $query = "
    SELECT 
        u.Username AS studentName, 
        s.studentId, 
        ss.simulatorId, 
        a.question_Id, 
        q.question, 
        a.answer, 
        ss.createdAt AS sessionDate,
        r.review
    FROM users u 
    JOIN students s ON u.userId = s.userId 
    JOIN simulator_sessions ss ON s.studentId = ss.studentId 
    JOIN answers a ON ss.simulatorId = a.simulator_Id 
    JOIN questions q ON a.question_Id = q.QuestionID 
    LEFT JOIN reviews r ON ss.simulatorId = r.simulatorId AND s.studentId = r.studentId
    ORDER BY ss.simulatorId, u.userName, a.question_Id;
    ";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Results Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/styles/simulationResults.css">
    <!-- <link rel="stylesheet" href="../../public/assets/styles/counselor_dashboard.css"> -->
</head>
<body>
<header>
        <nav class="navbar">
            <?php require_once __DIR__ . "/../../tests/Navbar2.php"; ?>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <div class="pos-sidebar" >
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Appointment List</a>
            <!-- <a href="bookCounselors.php">Calendar</a>
            <a href="InterviewSimulator.php">Insights</a> -->
            <a href="#">Resumes</a>
            <a href="#">Discussion Forum</a>
        </div>
    </div>

    <div class="container">
       
            
            <h1 class="dashboard-title">Interview Simulation Results </h1>

        <?php
        $currentSimulatorId = null;
        $currentStudentId = null;

        foreach ($results as $row) {
            $reviewExists = !empty($row['review']); // Check if a review exists
        
            if ($currentSimulatorId !== $row['simulatorId'] || $currentStudentId !== $row['studentId']) {
                if ($currentSimulatorId !== null) {
                    echo "</div></div>"; // Close answers-container and session-card
                }
                ?>
                <div class="session-card">
                    <div class="session-header">
                        <div class="session-info">
                            <div>
                                <h2 class="session-title">Interview Session #<?php echo htmlspecialchars($row['simulatorId']); ?></h2>
                                <p class="student-info">
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($row['studentName']); ?> | 
                                    <i class="fas fa-calendar"></i> <?php echo date('F j, Y, g:i a', strtotime($row['sessionDate'])); ?>
                                </p>
                            </div>
                            <span class="status-badge <?php echo $reviewExists ? 'status-reviewed' : 'status-pending'; ?>">
                                <i class="fas fa-<?php echo $reviewExists ? 'check' : 'clock'; ?>"></i> 
                                <?php echo $reviewExists ? 'Reviewed' : 'Pending Review'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <?php if (!$reviewExists): ?>
<div class="action-buttons">
    <button class="btn btn-primary" onclick="toggleAnswers(this)">
        <i class="fas fa-chevron-down icon"></i> View Answers
    </button>
    <button class="btn btn-secondary" onclick="toggleReview(this)">
        <i class="fas fa-comment icon"></i> Add Review
    </button>
</div>

<div class="review-form">
    <form action="../helpers/submit_review.php" method="POST">
        <textarea name="review" class="review-textarea" placeholder="Enter your feedback for this interview session..."></textarea>
        <input type="hidden" name="simulatorId" value="<?php echo htmlspecialchars($row['simulatorId']); ?>">
        <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($row['studentId']); ?>">
        <input type="hidden" name="counselorId" value="<?php echo htmlspecialchars($counselorId); ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane icon"></i> Submit Review
        </button>
    </form>
</div>
<?php endif; ?>

        
                    <div class="answers-container">
                <?php
            }
        
            echo "<div class='qa-pair'>";
            echo "<div class='question'><i class='fas fa-question-circle'></i> " . htmlspecialchars($row['question']) . "</div>";
            echo "<div class='answer'>" . htmlspecialchars($row['answer']) . "</div>";
            echo "</div>";
        
            $currentSimulatorId = $row['simulatorId'];
            $currentStudentId = $row['studentId'];
        }
        
        if ($currentSimulatorId !== null) {
            echo "</div></div>"; // Close last answers-container and session-card
        }
        ?>
        
    </div>

    <script src="../../public/assets/scripts/simulatorresults.js"></script>
</body>
</html>

