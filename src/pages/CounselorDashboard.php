<?php
require "../helpers/crud_routes.php";


session_start();



// Simulating data retrieval from login/signup form
$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour Bassem';
$_SESSION['counselor_id'] = isset($_POST['counselor_id']) ? $_POST['counselor_id'] : 1;
$_SESSION['address'] = isset($_POST['address']) ? $_POST['address'] : 'El Sherouk';
$_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : 'nour@gmail.com';
$_SESSION['department'] = isset($_POST['department']) ? $_POST['department'] : 'No department';
$_SESSION['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '+1 (609) 972-22-22';

// Simulating data for career development tasks
$tasks = [
    [
        'icon' => '1',
        'title' => 'CV Assessment',
        'description' => 'Your Psychometric Assessment is yet to be completed. Head over now to get one step ahead in your career planning journey',
        'status' => 'pending'
    ],
    [
        'icon' => '✓',
        'title' => 'Fill Profile Details',
        'description' => 'Complete your Profile Details to help us customize your guidance program',
        'status' => 'completed'
    ],
    [
        'icon' => '3',
        'title' => 'Interview Simulation Program',
        'description' => 'Take multiple interviews with professtonal counselor and understand the inner workings of recruitment progress',
        'status' => 'pending'
    ],
    [
        'icon' => '4',
        'title' => 'Evaluate Profile',
        'description' => 'Evaluate and enhance your profile to increase your chances of getting into your dream college',
        'status' => 'pending'
    ]
];

$connections = [
    [
        'name' => 'Rachel Doe',
        'connections' => 25,
        'image' => 'R',
        'status' => 'connected'
    ],
    [
        'name' => 'Isabella Finley',
        'connections' => 79,
        'image' => 'isabella.jpg',
        'status' => 'pending'
    ],
    [
        'name' => 'David Harrison',
        'connections' => 0,
        'image' => 'david.jpg',
        'status' => 'connected'
    ],
    [
        'name' => 'Costa Quinn',
        'connections' => 9,
        'image' => 'costa.jpg',
        'status' => 'pending'
    ]
];

function formatDateTime($datetime){
     // Create a DateTime object from the given string
     $date = new DateTime($datetime);

     // Format the time to 12-hour format (AM/PM)
     $formattedTime = $date->format('g:i A'); // Example: "9:00 AM"
     
     // Format the date to dd/mm/yyyy
     $formattedDate = $date->format('d/m/Y'); // Example: "13/12/2024"
 
     // Return the formatted result with the time in bold and the date after it
     return "<b>{$formattedTime}</b> {$formattedDate}";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css"> -->
    <link rel="stylesheet" href="../../public/assets/styles/counselor_dashboard.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</head>
<body>

    <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
    </nav>

    
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="pos-sidebar" >
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Appointment List</a>
            <!-- <a href="bookCounselors.php">Calendar</a>
            <a href="InterviewSimulator.php">Insights</a> -->
            <a href="ResumeReview.php">Resumes</a>
            <a href="forum.php">Discussion Forum</a>
        </div>
    </div>

    <main class="main-content">
        <div class="greeting">Hey <?php echo htmlspecialchars($_SESSION['name']); ?>!</div>
        <?php
// Retrieve the json file of the appointments
$result = $appointmentsController->getAppointments($_SESSION['counselor_id']);
$appointments = json_decode($result, true);

if (is_array($appointments) && count($appointments) > 0) {
    ?>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment) { ?>
            <tr>
                <td><?php echo $appointment['student_name']; ?></td>
                <td><?php echo $appointment['student_email']; ?></td>
                <td><?php echo $appointment['student_phone']; ?></td>
                <td><?php echo formatDateTime($appointment['booking_date']); ?></td>
                <td class="status <?php echo $appointment['status']; ?>"><p><?php echo $appointment['status']; ?></p></td>
                <td class="actions-container">
                    <div class="stat">
                        <!-- Dynamically add the app_id to the buttons -->
                        <button id = "approve" class="status-buttons approve-button" data-id="<?php echo $appointment['app_id']; ?>" data-status="approved">Approve</button>
                        <button id = "reject" class="status-buttons reject-button" data-id="<?php echo $appointment['app_id']; ?>" data-status="denied">Reject</button>
                    </div>
                    <button class="delete"><box-icon name='trash' type='solid' color='#fb0303'></box-icon></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
} else {
    echo "No appointments found.";
}
?>
    </main>

<script>
    document.querySelectorAll('.actions-container .stat .status-buttons').forEach(button => {
        button.addEventListener('click', function () {
            var appointment_id = this.getAttribute('data-id');
            var new_status = this.getAttribute('data-status');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', "<?php echo $_SERVER['REQUEST_URI']; ?>", true);  // Adjust the path as necessary
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status == 200) {
                    alert(xhr.responseText);  // Show the server response (success or error)
                }
            };

            xhr.send('appointment_id=' + appointment_id + '&status=' + new_status);
        });
    });
</script>

<!-- slider script -->
<script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function currentDiv(n) {
        showDivs(slideIndex = n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("slide");
        var dots = document.getElementsByClassName("dot");
        if (n > x.length) {slideIndex = 1}
        if (n < 1) {slideIndex = x.length}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        x[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
    }


// connections script 
document.addEventListener('DOMContentLoaded', function() {
    const list = document.querySelector('.connections-list');
    const scrollLeftBtn = document.querySelector('.scroll-left');
    const scrollRightBtn = document.querySelector('.scroll-right');
    const connectBtns = document.querySelectorAll('.connect-btn');

    scrollLeftBtn.addEventListener('click', () => {
        list.scrollBy({ left: -200, behavior: 'smooth' });
    });

    scrollRightBtn.addEventListener('click', () => {
        list.scrollBy({ left: 200, behavior: 'smooth' });
    });

    connectBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.dataset.status !== 'connected') {
                this.dataset.status = 'connected';
                this.textContent = '✓';
                this.style.backgroundColor = '#4caf50';
            } else {
                this.dataset.status = 'not-connected';
                this.textContent = '+';
                this.style.backgroundColor = '#2196f3';
            }
        });
    });

    
        
});




</script>

    
</body>
</html>



