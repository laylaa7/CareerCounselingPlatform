<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <link rel="stylesheet" href="../../public/assets/styles/ResumeBuilder.css"> 

</head>
<header>
    <div>
    <nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>
</div>
    </header>
<body>


    <div class="container">
        <div class="sidebar">
            <button class="back-button">←</button>
            <div class="progress-item active" data-section="personal-info">Personal info</div>
            <div class="progress-item" data-section="education">Education</div>
            <div class="progress-item" data-section="work-history">Work history</div>
            <div class="progress-item" data-section="skills">Skills</div>
            <div class="progress-item" data-section="overview">Overview</div>
        </div>
        <div class="main-content">
            <div id="personal-info" class="section active">
                <h1>Provide your employers with your contact info:</h1>
                <div class="form-group">
                    <label for="first-name">First name *</label>
                    <input type="text" id="first-name" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname *</label>
                    <input type="text" id="surname" required>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" id="phone">
                </div>
            </div>
            <div id="education" class="section">
                <h1>Education</h1>
                <h5>Enter your education experience so far, even if you are a current student or did not graduate:</h5>
                <div class="form-group">
                    <label for="School-name">School name *</label>
                    <input type="text" id="School-name" required>
                </div>
                <div class="form-group">
                    <label for="School-location">Schoolname *</label>
                    <input type="text" id="School-name" required>
                </div>
                <div class="form-group">
                    <label for="Degree">Degree</label>
                    <input type="text" id="Degree">
                </div>
                <div class="form-group">
                    <label for="Field-of-study">Field of study</label>
                    <input type="text" id="Field-of-study">
                </div>
                <div class="form-group">
                    <label for="graduation-date">graduation date</label>
                    <input type="text" id="graduation-date">
                </div>
            </div>
            <div id="work-history" class="section">
                <h1>Work History</h1>
                <h5>Tell us about your most recent job:</h5>
                <div class="form-group">
                    <label for="Job-Title">Job Title *</label>
                    <input type="text" id="Job-Title" required>
                </div>
                <div class="form-group">
                    <label for="employer">employer *</label>
                    <input type="text" id="employer" required>
                </div>
                <div class="form-group">
                    <label for="location">location</label>
                    <input type="text" id="location">
                </div>
                <div class="form-group">
                    <label for="remote">remote</label> <!-- radio button-->
                    <input type="text" id="location">
                </div>
                <div class="form-group">
                    <label for="start-date">start date</label>
                    <input type="text" id="start-date">
                </div>
                <div class="form-group">
                    <label for="End-date">End date</label>
                    <input type="text" id="End-date">
                </div>
                <div class="form-group">
                    <label for="status">Do you currently work here?</label>  <!-- radio button-->
                    <input type="text" id="status">
                </div>
            </div>

            <div id="skills" class="section">
                <h1>Skills</h1>
                <!-- Add skills fields here -->
            </div>
            <div id="overview" class="section">
                <h1>Overview</h1>
                <div class="overview-pic">
                
                <img src="../../public/assets/images/ResumeOverview.png" alt="Profile Picture">
            </div>
            </div>
            <div class="button-group">
                <button id="prev-btn" disabled>Previous</button>
                <button id="next-btn">Next</button>
            </div>
        </div>
    </div>
    <script src="../../public/assets/scripts/ResumeBuilder.js"></script>

</body>
</html>