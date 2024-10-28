<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
        <?php include "../../public/assets/styles/bookCouncelors.css" ?>
    </style>
</head>
<body class="body">
<nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>
    
    <div class="calendar-popup" id="calendarPopup">
    <div class="calendar-content">
        <div class="calendar-header">
            <h2>Select a Date & Time</h2>
            <button class="close-btn" onclick="closeCalendar()">&times;</button>
        </div>
        <div class="calendar-body">
            <div class="month-selector">
                <button onclick="previousMonth()">&lt;</button>
                <span id="currentMonth">October 2024</span>
                <button onclick="nextMonth()">&gt;</button>
            </div>
            <div class="calendar-grid">
                <div class="weekdays">
                    <div>SUN</div>
                    <div>MON</div>
                    <div>TUE</div>
                    <div>WED</div>
                    <div>THU</div>
                    <div>FRI</div>
                    <div>SAT</div>
                </div>
                <div id="calendar-dates" class="dates">
                    <!-- Dates will be populated by JavaScript -->
                </div>
            </div>
            <div class="time-slots">
                <h3>Available Times</h3>
                <div class="time-buttons">
                    <button class="time-btn">11:00am</button>
                    <button class="time-btn">11:30am</button>
                    <button class="time-btn">12:00pm</button>
                    <button class="time-btn">12:30pm</button>
                    <button class="time-btn">1:00pm</button>
                    <button class="time-btn">1:30pm</button>
                </div>
            </div>
            <div class="timezone-selector">
                <label>Time zone</label>
                <select>
                    <option>Africa/Cairo (9:50pm)</option>
                </select>
            </div>
        </div>
    </div>
</div>

    <div class="counselors-container">
        <a href="userDashboard.php" class="back-button">← Back to Dashboard</a>
        <h1 class="career-title">Career Counselors</h1>

        <div class="counselors-list">
            <?php
            $counselors = array(
                array(
                    "name" => "Salma Khalil",
                    "email" => "salma@gmail.com",
                    "position" => "Director",
                    "department" => "Human resources",
                    "location" => "Germany",
                    "status" => "active",
                    "completion" => "72",
                    "role" => "Employee",
                    "verified" => true,
                ),
                array(
                    "name" => "Anne Richard",
                    "email" => "anne@site.com",
                    "position" => "Seller",
                    "department" => "Branding products",
                    "location" => "United States",
                    "status" => "pending",
                    "completion" => "24",
                    "role" => "Employee",
                    "verified" => false,
                ),
                array(
                    "name" => "Nour bassem",
                    "email" => "nour@gmail.com",
                    "position" => "Developer",
                    "department" => "Web developer",
                    "location" => "Egypt",
                    "status" => "suspended",
                    "completion" => "100",
                    "role" => "Employee",
                    "verified" => true,
                ),
                //  rest of the counselors
            );

            foreach($counselors as $counselor) {
                echo '<div class="counselor-row">';
                
                // Image
                    echo '<img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">';

                // Counselor Info
                echo '<div class="counselor-info">';
                
                echo '<div class="name-email">';
                echo '<div class="name">' . $counselor["name"];
                if($counselor["verified"]) echo '<img src="../../public/assets/images/verified.png" class="verified-badge">';
                echo '</div>';
                echo '<div class="email">' . $counselor["email"] . '</div>';
                echo '</div>';

                echo '<div class="position">';
                echo '<div>' . $counselor["position"] . '</div>';
                echo '<div class="department">' . $counselor["department"] . '</div>';
                echo '</div>';

                echo '<div class="location">' . $counselor["location"] . '</div>';

                echo '<div class="status">';
                echo '<span class="status-dot ' . $counselor["status"] . '"></span>';
                echo ucfirst($counselor["status"]);
                echo '</div>';

                echo '<div class="completion">';
                echo $counselor["completion"] . '%';
                echo '<div class="progress-bar" style=" background-color:lightgray;">';
                echo '<div class="progress-fill" style="width: ' . $counselor["completion"] .'% "></div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="role">' . $counselor["role"] . '</div>';

                echo '
                <button class="book-btn">
                  <p class="text">Book</p>
                </button>
                ';

                echo '</div>'; 
                echo '</div>'; 
            }
            ?>
        </div>
    </div>

<!--booking counselors script -->
<script>
    function showCalendar() {
    document.getElementById('calendarPopup').style.display = 'block';
}

function closeCalendar() {
    document.getElementById('calendarPopup').style.display = 'none';
}

function generateCalendar() {
    const calendar = document.getElementById('calendar-dates');
    calendar.innerHTML = '';
    

    const daysInMonth = 31;
    const firstDay = 2; 
    
    //  empty cells for days before the 1st
    for(let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        calendar.appendChild(emptyDay);
    }
    
    // calendar days
    for(let day = 1; day <= daysInMonth; day++) {
        const button = document.createElement('button');
        button.className = 'date-btn';
        button.textContent = day;
        button.onclick = () => selectDate(day);
        calendar.appendChild(button);
    }
}

function selectDate(day) {
    // Remove previous selection
    document.querySelectorAll('.date-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    // Add selection to clicked date
    event.target.classList.add('selected');
}

function previousMonth() {
    // Implement previous month logic
}

function nextMonth() {
    // Implement next month logic
}

document.addEventListener('DOMContentLoaded', () => {
    generateCalendar();
    
    document.querySelectorAll('.book-btn').forEach(btn => {
        btn.onclick = showCalendar;
    });
});
</script>

</body>
</html>