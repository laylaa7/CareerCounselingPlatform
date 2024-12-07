<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update with your DB username
$password = ""; // Update with your DB password
$dbname = "trial#1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch skills
$sql = "SELECT skill_name, category, proficiency_level FROM skills";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link rel="stylesheet" href="../../public/assets/styles/ResumeBuilder.css">
</head>
<body>
<header>
    <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
    </nav>
</header>

<div class="container">
    <!-- Sidebar for navigation -->
    <div class="sidebar">
        <button class="back-button">←</button>
        <div class="progress-item active" data-section="personal-info">Personal Info</div>
        <div class="progress-item" data-section="education">Education</div>
        <div class="progress-item" data-section="work-history">Work History</div>
        <div class="progress-item" data-section="skills">Skills</div>
        <div class="progress-item" data-section="overview">Overview</div>
    </div>

    <!-- Main content area -->
    <div class="main-content">
    <form action="ResumeGenerator.php" method="POST" enctype="multipart/form-data">
        <!-- Personal Info Section -->
        <div id="personal-info" class="section active">
            <h1>Provide your contact information:</h1>
            <div class="form-group">
                <label for="first-name">First Name *</label>
                <input type="text" id="first-name" name="first-name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname *</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone">
            </div>
        </div>

        <!-- Education Section -->
        <div id="education" class="section">
            <h1>Education</h1>
            <p>Enter your education experience so far, even if you're a current student or did not graduate:</p>
            <div class="form-group">
                <label for="school-name">School Name *</label>
                <input type="text" id="school-name" name="school-name" required>
            </div>
            <div class="form-group">
                <label for="degree">Degree</label>
                <input type="text" id="degree" name="degree">
            </div>
            <div class="form-group">
                <label for="field-of-study">Field of Study</label>
                <input type="text" id="field-of-study" name="field-of-study">
            </div>
            <div class="form-group">
                <label for="graduation-date">Graduation Date</label>
                <input type="date" id="graduation-date" name="graduation-date">
            </div>
        </div>

        <!-- Work History Section -->
        <div id="work-history" class="section">
            <h1>Work History</h1>
            <p>Tell us about your most recent job:</p>
            <div class="form-group">
                <label for="job-title">Job Title *</label>
                <input type="text" id="job-title" name="job-title" required>
            </div>
            <div class="form-group">
                <label for="employer">Employer *</label>
                <input type="text" id="employer" name="employer" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location">
            </div>
            <div class="form-group">
                <label for="start-date">Start Date</label>
                <input type="date" id="start-date" name="start-date">
            </div>
            <div class="form-group">
                <label for="end-date">End Date</label>
                <input type="date" id="end-date" name="end-date">
            </div>
            <div class="form-group">
                <label>Do you currently work here?</label>
                <input type="radio" id="status-yes" name="status" value="yes">
                <label for="status-yes">Yes</label>
                <input type="radio" id="status-no" name="status" value="no">
                <label for="status-no">No</label>
            </div>
        </div>

        <!-- Skills Section -->
        <div id="skills" class="section">
            <h1>Skills</h1>
            <div class="skill-input-container">
                <input type="text" id="skill-input" placeholder="Type a skill...">
                <button id="add-skill-btn" class="add-btn">Add Skill</button>
            </div>

            <!-- Predefined skills dropdown -->
            <div class="predefined-skills">
                <h3>Or choose from common skills:</h3>
                <div id="predefined-skills-list">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<button class="predefined-skill" data-skill="' . htmlspecialchars($row['skill_name']) . '">' 
                            . htmlspecialchars($row['skill_name']) . '</button>';
                        }
                    } else {
                        echo "<p>No predefined skills found.</p>";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>

            <!-- Selected skills display -->
            <div class="selected-skills">
                <h3>Your Skills:</h3>
                <div id="selected-skills-list" class="skills-list">
                    <!-- Selected skills will appear here -->
                </div>
            </div>
        </div>

        <!-- Overview Section -->
        <div id="overview" class="section">
            <h1>Overview</h1>
            <div class="overview-pic">
                <img src="../../public/assets/images/ResumeOverview.png" alt="Profile Picture">
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="button-group">
            <button id="prev-btn" disabled>Previous</button>
            <button id="next-btn">Next</button>
        </div>
    </form>
    </div>

</div>

<script src="../../public/assets/scripts/ResumeBuilder.js"></script>
</body>
</html>
