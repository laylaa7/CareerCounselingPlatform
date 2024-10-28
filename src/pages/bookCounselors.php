<?php
session_start();

// Simulating data for counselors
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
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
       <?php include "../../public/assets/styles/bookCounselors.css"; ?>
    </style>
</head>
<body class="body">
    
    <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
    </nav>
    
    <div class="calendar-popup" id="calendarPopup">
        <div class="calendar-content">
            <div class="calendar-header">
                <button class="back-btn" onclick="closeCalendar()">← Back</button>
                <h2>Select a Date & Time</h2>
                <button class="close-btn" onclick="closeCalendar()">&times;</button>
            </div>
            <div class="calendar-body">
                <div class="calendar-left">
                    <h3 id="counselorName">Counselor Name</h3>
                    <p id="counselorDuration">30 min</p>
                    <p>Web conferencing details provided upon confirmation.</p>
                </div>
                <div class="calendar-right">
                    <div class="month-selector">
                        <button onclick="changeMonth(-1)">&lt;</button>
                        <span id="currentMonth">October 2024</span>
                        <button onclick="changeMonth(1)">&gt;</button>
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
                        <div id="time-buttons" class="time-buttons">
                            <!-- Time slots will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="timezone-selector">
                        <label for="timezone">Time zone</label>
                        <select id="timezone">
                            <option>Africa/Cairo (9:50pm)</option>
                        </select>
                    </div>
                    <button id="bookButton" class="book-button" onclick="bookAppointment()">Book</button>
                </div>
            </div>
        </div>
    </div>

    <div class="counselors-container">
        <a href="userDashboard.php" class="back-button">← Back to Dashboard</a>
        <h1 class="career-title">Career Counselors</h1>

        <div class="counselors-list">
            <?php foreach($counselors as $counselor): ?>
                <div class="counselor-row">
                    <img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">
                    <div class="counselor-info">
                        <div class="name-email">
                            <div class="name">
                                <?php echo htmlspecialchars($counselor["name"]); ?>
                                <?php if($counselor["verified"]): ?>
                                    <img src="../../public/assets/images/verified.png" class="verified-badge" alt="Verified">
                                <?php endif; ?>
                            </div>
                            <div class="email"><?php echo htmlspecialchars($counselor["email"]); ?></div>
                        </div>
                        <div class="position">
                            <div><?php echo htmlspecialchars($counselor["position"]); ?></div>
                            <div class="department"><?php echo htmlspecialchars($counselor["department"]); ?></div>
                        </div>
                        <div class="location"><?php echo htmlspecialchars($counselor["location"]); ?></div>
                        <div class="status">
                            <span class="status-dot <?php echo $counselor["status"]; ?>"></span>
                            <?php echo ucfirst($counselor["status"]); ?>
                        </div>
                        <div class="completion">
                            <?php echo $counselor["completion"]; ?>%
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $counselor["completion"]; ?>%"></div>
                            </div>
                        </div>
                        <div class="role"><?php echo  htmlspecialchars($counselor["role"]); ?></div>
                        <button class="book-btn" onclick="showCalendar('<?php echo htmlspecialchars($counselor["name"]); ?>')">
                            <span class="text">Book</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<script>
let selectedDate = null;
let selectedTime = null;
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

function showCalendar(counselorName) {
    document.getElementById('calendarPopup').style.display = 'block';
    document.getElementById('counselorName').textContent = counselorName;
    generateCalendar();
}

function closeCalendar() {
    document.getElementById('calendarPopup').style.display = 'none';
    selectedDate = null;
    selectedTime = null;
    updateBookButton();
}

function generateCalendar() {
    const calendar = document.getElementById('calendar-dates');
    calendar.innerHTML = '';
    
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    
    document.getElementById('currentMonth').textContent = `${new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' })} ${currentYear}`;
    
    for(let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        calendar.appendChild(emptyDay);
    }
    
    const today = new Date();
    for(let day = 1; day <= daysInMonth; day++) {
        const button = document.createElement('button');
        button.className = 'date-btn';
        button.textContent = day;
        
        const date = new Date(currentYear, currentMonth, day);
        if (date < today) {
            button.disabled = true;
            button.classList.add('disabled');
        } else {
            button.onclick = () => selectDate(day);
        }
        
        calendar.appendChild(button);
    }
}

function selectDate(day) {
    document.querySelectorAll('.date-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    event.target.classList.add('selected');
    selectedDate = day;
    generateTimeSlots();
    updateBookButton();
}

function generateTimeSlots() {
    const timeSlots = ['11:00am', '11:30am', '12:00pm', '12:30pm', '1:00pm', '1:30pm'];
    const timeButtons = document.getElementById('time-buttons');
    timeButtons.innerHTML = '';
    
    timeSlots.forEach(time => {
        const button = document.createElement('button');
        button.className = 'time-btn';
        button.textContent = time;
        button.onclick = () => selectTime(time);
        timeButtons.appendChild(button);
    });
}

function selectTime(time) {
    document.querySelectorAll('.time-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    event.target.classList.add('selected');
    selectedTime = time;
    updateBookButton();
}

function updateBookButton() {
    const bookButton = document.getElementById('bookButton');
    if (selectedDate && selectedTime) {
        bookButton.disabled = false;
        bookButton.textContent = `Book (${selectedDate} ${new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' })} ${currentYear}, ${selectedTime})`;
    } else {
        bookButton.disabled = true;
        bookButton.textContent = 'Book';
    }
}

function changeMonth(delta) {
    currentMonth += delta;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    } else if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar();
}

function bookAppointment() {
    if (selectedDate && selectedTime) {
        alert(`Appointment booked for ${selectedDate} ${new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' })} ${currentYear} at ${selectedTime}`);
        closeCalendar();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    generateCalendar();
});
</script>

</body>
</html>