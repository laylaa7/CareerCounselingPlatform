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

$_SESSION['name'] = isset($_SESSION['username']) ? $_SESSION['username'] : 'Counselor';
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
    <!-- Updated FullCalendar CDN Links -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
</head>
<body>

    <nav class="navbar">
        <?php include PROJECT_ROOT . "../../tests/Navbar.php"; ?>
    </nav>

    <div class="dashboard-container">
        <div class="sidebar">
            <div class="pos-sidebar">
                <a href="/CareerCounseling/CareerCounselingPlatform/home/index" class="dash">Dashboard</a>
                <a href="#" class="dash2">Appointment List</a>
                <!-- <a href="bookCounselors.php">Calendar</a>
                <a href="InterviewSimulator.php">Insights</a> -->
                <a href="#">Resumes</a>
                <a href="#">Discussion Forum</a>
            </div>
        </div>

        <main class="main-content">
            <div class="greeting">Hey <?php echo htmlspecialchars($appointmentsController->getCounselorName($_SESSION['counselor_id'])); ?>!</div>
            <div class="statistics-container">
                <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                    <h1><?php echo count($appointments); ?></h1>
                    <p>Number of Appointments</p>
                </div>
                <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                    <h1><?php 
                        echo count(array_filter($appointments, function($appointment) {
                            return $appointment['notes'] === 'approved';
                        })); 
                    ?></h1>
                    <p>Number of Approved Appointments</p>
                </div>
                <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                    <h1><?php 
                        echo count(array_filter($appointments, function($appointment) {
                            return $appointment['notes'] === 'denied';
                        })); 
                    ?></h1>
                    <p>Number of Denied Appointments</p>
                </div>
                <div style="--shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;">
                    <h1><?php 
                        echo count(array_unique(array_column($appointments, 'StudentID'))); 
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
                    <button onclick="switchView('calendar')"><box-icon name='calendar' type='solid'></box-icon></button>
                </div>
            </div>
            <?php
            // Retrieve appointments
            $result = $appointmentsController->getAppointments($_SESSION['counselor_id']);
            $appointments = json_decode($result, true);
            

            if (is_array($appointments) && count($appointments) > 0) {
                ?>
                <div id="appointments-view" style="width: 100%; user-select: none;">
                </div>
                
                <?php
            } else {
                echo "No appointments found.";
            }
            ?>
        </main>

        <script>
            let calendar; // Declare calendar variable globally
            let currentView = 'table'; // Track the current view

            window.onload = () => {
                filterAppointments();
            }

            function changeAppointmentStatus(appointment_id, new_status) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "/CareerCounseling/CareerCounselingPlatform/appointments/changeStatus", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        var statusElement = document.getElementById("stat-" + appointment_id);
                        statusElement.classList.remove("pending", "approved", "denied");
                        statusElement.classList.add(new_status);
                        statusElement.innerHTML = "<p>" + new_status + "</p>";
                        // Refresh the current view
                        if (currentView === 'calendar') {
                            filterAppointments();
                        }
                    }
                };

                xhr.send('appointment_id=' + appointment_id + '&new_status=' + new_status);
            }
            
            function formatDateTime(date) {
                
                if (!date) return 'Invalid Date';

                const options = {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };

                const formattedDate = new Date(date).toLocaleString('en-US', options);
                return formattedDate;
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
                            console.log(data); // Verify data structure
                            if (currentView === 'calendar') {
                                renderCalendarView(data);
                            } else {
                                renderTableView(data);
                            }
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
                currentView = view;
                if (view === 'calendar') {
                    filterAppointments();
                } else {
                    filterAppointments();
                }
            }

            function renderTableView(appointments) {
                let html = '<table class="appointments-table"><thead><tr><th>Student Name</th><th>Email</th><th>Phone</th><th>Booking Date</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                appointments.forEach(appointment => {
                    
                    html += `<tr>
                        <td>${appointment.student_name}</td>
                        <td>${appointment.student_email}</td>
                        <td>${appointment.student_phone}</td>
                        <td>${formatDateTime(appointment.date)}</td>
                        <td class="status ${appointment.notes}" id="stat-${appointment.SessionID}"><p>${appointment.notes}</p></td>
                        <td class="actions-container">
                            <div class="stat">
                                <button class="status-buttons approve-button" onclick="changeAppointmentStatus('${appointment.SessionID}','approved')">Approve</button>
                                <button class="status-buttons reject-button" onclick="changeAppointmentStatus('${appointment.SessionID}','denied')">Reject</button>
                            </div>
                            <button class="delete" onclick="deleteAppointment('${appointment.SessionID}')"><box-icon name='trash' type='solid' color='#fb0303'></box-icon></button>
                        </td>
                    </tr>`;
                });
                html += '</tbody></table>';
                document.getElementById('appointments-view').style = ""
                document.getElementById('appointments-view').classList = []
                document.getElementById('appointments-view').innerHTML = html;

            }

            function renderCalendarView(appointments) {
                let events = appointments.map(appointment => {
                    return {
                        title: appointment.student_name,
                        start: new Date(appointment.date).toISOString(),
                        description: appointment.notes
                    };
                });

                let calendarEl = document.getElementById('appointments-view');
                // Clear previous calendar if exists
                calendarEl.innerHTML = '';

                if (calendar) {
                    calendar.destroy();
                }

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: events,
                    eventContent: function(arg) {
                        let italicEl = document.createElement('span');
                        italicEl.innerHTML = '<b>' + arg.event.title + '</b><br>' + arg.event.extendedProps.description;
                        let arrayOfDomNodes = [ italicEl ];
                        return { domNodes: arrayOfDomNodes };
                    }
                });
                calendar.render();
            }

            function deleteAppointment(appointment_id) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/CareerCounseling/CareerCounselingPlatform/appointments/delete', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        console.log('Appointment deleted successfully' + xhr.responseText);
                        filterAppointments();
                    } else {
                        console.error('Failed to delete appointment');
                    }
                };

                xhr.send('appointment_id=' + appointment_id);
            }
        </script>

</body>
</html>