<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Generator</title>
    <link rel="stylesheet" href="../../public/assets/styles/ResumeBuilder.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <?php include "../../tests/Navbar2.php"; ?>
        </nav>
    </header>
    <div class="profile-container">
    <div class="sidebar">
        <button class="back-button"><a href="userDashboard.php">←</a></button>
        <h2>Nour B</h2>
        <hr>
        <ul class="profile-links">
            <li><a href="bookCounselors.php">Book with our counselors</a></li>
            <li><a href="ResumeReview.php">Resume Guide</a></li>
            <li><a href="forum.php">Discussions</a></li>
        </ul>
        <hr>
        <div class="logout">
            <a href="#">Log out</a>
        </div>
    </div>
        <div class="container">
            <h1>Resume Generator</h1>
            
            <form id="resumeForm" action="ResumeGenerator.php" method="POST">
                <!-- Personal Information -->
                <div class="section">
                    <h2>Personal Information</h2>
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address">
                    </div>
                </div>

                <!-- Education -->
                <div class="section">
                    <h2>Education</h2>
                    <div id="educationContainer">
                        <div class="education-entry">
                            <div class="form-group">
                                <label>Degree</label>
                                <input type="text" name="degree[]" required>
                            </div>
                            <div class="form-group">
                                <label>Institution</label>
                                <input type="text" name="institution[]" required>
                            </div>
                            <div class="form-group">
                                <label>Graduation Year</label>
                                <input type="number" name="gradYear[]" min="1900" max="2099">
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addEducation">+ Add Education</button>
                </div>

                <!-- Work Experience -->
                <div class="section">
                    <h2>Work Experience</h2>
                    <div id="workContainer">
                        <div class="work-entry">
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" name="jobTitle[]" required>
                            </div>
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" name="company[]" required>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="startDate[]">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="endDate[]">
                            </div>
                            <div class="form-group">
                                <label>Job Description</label>
                                <textarea name="jobDescription[]"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addWork">+ Add Work Experience</button>
                </div>

                <!-- Skills -->
                <div class="section">
                    <h2>Skills</h2>
                    <div id="skillsContainer">
                        <div class="skills-entry">
                            <div class="form-group">
                                <label>Skill</label>
                                <input type="text" name="skill[]">
                            </div>
                            <div class="form-group">
                                <label>Proficiency</label>
                                <select name="skillLevel[]">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addSkill">+ Add Skill</button>
                </div>

                <!-- Actions -->
                <div class="actions">
                    <button type="submit">Generate Resume</button>
                    <button type="button" id="previewBtn">Preview</button>
                </div>
            </form>

            <!-- Preview Modal -->
            <div id="previewModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="previewContent"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/assets/scripts/ResumeBuilder.js"></script>
</body>
</html>
