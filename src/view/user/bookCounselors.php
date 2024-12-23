<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CareerCompass";

$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and get StudentID
// if (!isset($_SESSION['user_id'])) {
//     die(json_encode(['success' => false, 'message' => 'User not logged in']));
// }
// $studentId = $_SESSION['user_id'];


// Fetch counselors with username and email from the database
$sql = "SELECT u.Username, u.Email, c.position, c.specialization, c.location, c.status, c.verified, c.No_of_Connections AS completion
        FROM counselors c
        INNER JOIN users u ON c.UserID = u.UserID
        WHERE u.User_Role = 1";
$result = $conn->query($sql);

$counselors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $counselors[] = $row;
    }
}


// Handle POST request for booking appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentDate = $_POST['date'] ?? '';
    $appointmentTime = $_POST['time'] ?? '';
    $counselorName = $_POST['counselorName'] ?? '';

    if (!$appointmentDate || !$appointmentTime || !$counselorName) {
        echo "<script>alert('Missing required data'); window.history.back();</script>";
        exit;
    }

    $time = DateTime::createFromFormat('g:ia', $appointmentTime); // Converttime format to 24-hour format
    if ($time === false) {
        echo "<script>alert('Invalid time format'); window.history.back();</script>";
        exit;
    }
    $time24 = $time->format('H:i:s');

    $appointmentDateTime = $appointmentDate . ' ' . $time24;

    $sql = "SELECT c.CounselorID 
            FROM counselors c 
            INNER JOIN users u ON c.UserID = u.UserID 
            WHERE u.Username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $counselorName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Counselor not found'); window.history.back();</script>";
        exit;
    }

    $counselor = $result->fetch_assoc();
    $counselorId = $counselor['CounselorID'];

    //using fixed StudentID
    $studentId = 1;

    $sql = "INSERT INTO counselingsessions (StudentID, CounselorID, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $studentId, $counselorId, $appointmentDateTime);

    if ($stmt->execute()) {
        echo "<script>
                alert('Appointment booked successfully!');
                window.location.href = 'bookCounselors.php';
              </script>";
    } else {
        echo "<script>
                alert('Error booking appointment: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
       <?php include "../../../public/assets/styles/bookCounselors.css"; ?>
    </style>
</head>
<body class="body">
    
    <nav class="navbar">
        <?php include "../../../tests/Navbar2.php"; ?>
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
                            <!-- Dates populated by JavaScript -->
                        </div>
                    </div>
                    <div class="time-slots">
                        <div id="time-buttons" class="time-buttons">
                            <!-- Time slots populated by JavaScript -->
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
            <?php foreach ($counselors as $counselor): ?>
                <div class="counselor-row">
                    <img src="../../../public/assets/images/profile.png" class="profile-img" alt="Profile">
                                <div class="counselor-info">
                        <div class="name-role">
                            <div class="name">
                                <?php echo htmlspecialchars($counselor["Username"]); ?>
                                <?php if ($counselor["verified"]): ?>
                                    <img src="../../../public/assets/images/verified.png" class="verified-badge" alt="Verified">
                                <?php endif; ?>
                            </div>
                            <div class="email"><?php echo htmlspecialchars($counselor["Email"]); ?></div>
                        </div>

                        <div class="details">
                            <div class="position"><?php echo htmlspecialchars($counselor["position"]); ?></div>
                            <div class="specialization"><?php echo htmlspecialchars($counselor["specialization"]); ?></div>
                        </div>

                        <div class="location"><?php echo htmlspecialchars($counselor["location"]); ?></div>

                        <div class="status">
                            <span class="status-dot <?php echo $counselor["status"]; ?>"></span>
                            <?php echo ucfirst($counselor["status"]); ?>
                        </div>

                        <div class="completion">
                            <?php echo $counselor["completion"]; ?>%
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $counselor["completion"]; ?>%;"></div>
                            </div>
                        </div>

                        <button class="book-btn" onclick="showCalendar('Counselor: <?php echo htmlspecialchars($counselor['Username']); ?>')">
                            <span class="text">Book</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
    </div>

<script>
let selectedDate;
let selectedTime;
const calendar = document.getElementById('calendar');
const timeSelect = document.getElementById('timeSelect');
const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();

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
        const appointmentDate = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${selectedDate.toString().padStart(2, '0')}`;
        
        const counselorName = document.getElementById('counselorName').textContent.replace('Counselor: ', '');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'bookCounselors.php';

        const dateField = document.createElement('input');
        dateField.type = 'hidden';
        dateField.name = 'date';
        dateField.value = appointmentDate;
        form.appendChild(dateField);

        const timeField = document.createElement('input');
        timeField.type = 'hidden';
        timeField.name = 'time';
        timeField.value = selectedTime;
        form.appendChild(timeField);

        const counselorField = document.createElement('input');
        counselorField.type = 'hidden';
        counselorField.name = 'counselorName';
        counselorField.value = counselorName;
        form.appendChild(counselorField);

        document.body.appendChild(form);
        form.submit();
    }
}


document.addEventListener('DOMContentLoaded', () => {
    generateCalendar();
});
</script>

</body>
</html>