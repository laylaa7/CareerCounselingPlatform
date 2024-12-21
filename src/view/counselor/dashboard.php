<?php
// Session simulation

require_once PROJECT_ROOT . "/config/config.php";

require_once PROJECT_ROOT . "/controller/AppointmentsController.php";




// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize AppointmentsController
try {
    $appointmentsController = new AppointmentsController();
} catch (Exception $e) {
    die("Error initializing AppointmentsController: " . $e->getMessage());
}

// Example usage: Retrieve appointments for the logged-in counselor
$appointments = [];
if (isset($_SESSION['counselor_id'])) {
    $appointmentsJson = $appointmentsController->getAppointments($_SESSION['counselor_id']);
    $appointments = json_decode($appointmentsJson, true);
}

$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour Bassem';
$_SESSION['counselor_id'] = isset($_POST['counselor_id']) ? $_POST['counselor_id'] : 1;
$_SESSION['address'] = isset($_POST['address']) ? $_POST['address'] : 'El Sherouk';
$_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : 'nour@gmail.com';
$_SESSION['department'] = isset($_POST['department']) ? $_POST['department'] : 'No department';
$_SESSION['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '+1 (609) 972-22-22';

// Simulated data
$tasks = [
    [
        'icon' => '1',
        'title' => 'CV Assessment',
        'description' => 'Your Psychometric Assessment is yet to be completed.',
        'status' => 'pending'
    ],
    // other tasks...
];

$connections = [
    [
        'name' => 'Rachel Doe',
        'connections' => 25,
        'image' => 'R',
        'status' => 'connected'
    ],
    // other connections...
];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Use BASE_URL for asset links -->
    <link rel="stylesheet" href="/CareerCounseling/CareerCounselingPlatform/public/assets/styles/counselor_dashboard.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>

    <nav class="navbar">
        <?php include PROJECT_ROOT . "../../tests/Navbar.php"; ?>
    </nav>

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

    <main class="main-content">
        <div class="greeting">Hey <?php echo htmlspecialchars($_SESSION['name']); ?>!</div>
        <div class="statistics-container">
            <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                <h1><?php echo count($appointments); ?></h1>
                <p>Number of Appointments</p>
            </div>
            <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                <h1><?php 
                    echo count(array_filter($appointments, function($appointment) {
                        return $appointment['status'] === 'approved';
                    })); 
                ?></h1>
                <p>Number of approved Appointments</p>
            </div>
            <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                <h1><?php 
                    echo count(array_filter($appointments, function($appointment) {
                        return $appointment['status'] === 'denied';
                    })); 
                ?></h1>
                <p>Number of denied Appointments</p>
            </div>
            <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                <h1><?php 
                    echo count(array_unique(array_column($appointments, 'st_id'))); 
                ?></h1>
                <p>Number of Students</p>
            </div>
        </div>
        <div class="filters-container" style="--shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
            <div>
                <input type="text" id="search" placeholder="Search.." onkeyup="filterAppointments()">

                <select id="filter" onchange="filterAppointments()">
                    <option value="*">All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="denied">Denied</option>
                </select>
            </div>    
            <div class="view-buttons">
                <button onclick="switchView('table')"><box-icon name='table'></box-icon></button>
                <button onclick="switchView('calendar')"><box-icon name='calendar' type='solid' ></box-icon></button>
            </div>
        </div>
        <?php
        // Retrieve appointments
        $result = $appointmentsController->getAppointments($_SESSION['counselor_id']);
        $appointments = json_decode($result, true);

        if (is_array($appointments) && count($appointments) > 0) {
            ?>
            <div id="appointments-view" style = "width: 100%; user-select: none;">
            </div>
            
            <?php
        } else {
            echo "No appointments found.";
        }
        ?>
    </main>

<script>
    window.onload = () => {
        filterAppointments()
    }
    function changeAppointmentStatus(appointment_id, new_status) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "/CareerCounseling/CareerCounselingPlatform/appointments/changeStatus", true);  // Adjust the path as necessary
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status == 200) {
            var statusElement = document.getElementById("stat-" + appointment_id);
            statusElement.classList.remove("pending", "approved", "denied");
            statusElement.classList.add(new_status);
            statusElement.innerHTML = "<p>" + new_status + "</p>";
        }
    };

    xhr.send('appointment_id=' + appointment_id + '&new_status=' + new_status);
}
    
    function formatDateTime(datetime) {
        const date = new Date(datetime);

        // Format time as 'g:i A'
        const hours = date.getHours();
        const minutes = date.getMinutes();
        const formattedTime = `${hours % 12 || 12}:${minutes < 10 ? '0' : ''}${minutes} ${hours >= 12 ? 'PM' : 'AM'}`;

        // Format date as 'd/m/Y'
        const day = date.getDate();
        const month = date.getMonth() + 1; // Months are zero-indexed
        const year = date.getFullYear();
        const formattedDate = `${day < 10 ? '0' : ''}${day}/${month < 10 ? '0' : ''}${month}/${year}`;

        return `<b>${formattedTime}</b> ${formattedDate}`;
    }
    function filterAppointments() {
        const search = document.getElementById('search').value.trim();
        const filter = document.getElementById('filter').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/CareerCounseling/CareerCounselingPlatform/appointments/filter', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status == 200) {
                console.log(xhr.responseText); // Log the JSON string for inspection
                try {
                    const data = JSON.parse(xhr.responseText);
                    document.getElementById('appointments-view').innerHTML = renderTableView(data);
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Failed to fetch filtered appointments');
            }
        };

        if (search.length === 0 && filter === '*') {
            xhr.send('counselor_id=<?php echo $_SESSION['counselor_id']; ?>');
        } else if (filter !== "*" && search.length === 0) {
            xhr.send('filterStatus=' + encodeURIComponent(filter) + '&counselor_id=<?php echo $_SESSION['counselor_id']; ?>');
        } else if (search.length !== 0 && filter === "*") {
            xhr.send('searchTerm=' + encodeURIComponent(search) + '&counselor_id=<?php echo $_SESSION['counselor_id']; ?>');
        } else {
            xhr.send('searchTerm=' + encodeURIComponent(search) + '&filterStatus=' + encodeURIComponent(filter) + '&counselor_id=<?php echo $_SESSION['counselor_id']; ?>');
        }
    }

    function switchView(view) {
        //switch the view here...
    }

    function renderTableView(appointments) {
        let html = '<table class="appointments-table"><thead><tr><th>Student Name</th><th>Email</th><th>Phone</th><th>Booking Date</th><th>Status</th><th>Action</th></tr></thead><tbody>';
        appointments.forEach(appointment => {
            html += `<tr>
                <td>${appointment.student_name}</td>
                <td>${appointment.student_email}</td>
                <td>${appointment.student_phone}</td>
                <td>${formatDateTime(appointment.booking_date)}</td>
                <td class="status ${appointment.status}" id="stat-${appointment.app_id}"><p>${appointment.status}</p></td>
                <td class="actions-container">
                    <div class="stat">
                        <button class="status-buttons approve-button" onclick="changeAppointmentStatus('${appointment.app_id}','approved')">Approve</button>
                        <button class="status-buttons reject-button" onclick="changeAppointmentStatus('${appointment.app_id}','denied')">Reject</button>
                    </div>
                    <button class="delete" data-id="${appointment.app_id}"><box-icon name='trash' type='solid' color='#fb0303'></box-icon></button>
                </td>
            </tr>`;
        });
        html += '</tbody></table>';
        return html;
    }

    function renderView(data, viewType) {
        if (viewType === 'calendar') {
            // Render calendar view using a library like FullCalendar
            // Example: $('#appointments-view').fullCalendar({ events: data });
        } else {
            return renderTableView(data);
        }
    }

    

    document.querySelectorAll('.delete').forEach(button => {
    button.addEventListener('click', function () {
        var appointment_id = this.getAttribute('data-id');  // Get the appointment ID

        var xhr = new XMLHttpRequest();
        xhr.open('POST', "/CareerCounseling/CareerCounselingPlatform/appointments/delete", true);  // Adjust the path as necessary
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Successfully deleted, remove the row
                var row = button.closest('tr');
                row.remove();  // This will remove the row from the table
            } else {
                alert("Error deleting the appointment.");
            }
        };

        xhr.send('appointment_id=' + appointment_id);  // Send the appointment ID to the server
    });
});
</script>

</body>
</html>
