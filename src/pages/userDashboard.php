<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careercounseling";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] != 0) {
//     die("Unauthorized access. Please log in.");
// }

// $userId = $_SESSION['user_id'];
$userId = 3;

// Fetch user info from db
$sql = "
    SELECT 
        u.Username AS name, 
        u.Email AS email, 
        s.phone AS phone, 
        s.location AS address, 
        s.Degree AS degree, 
        s.major AS department, 
        s.university, 
        s.Grad_year AS gradYear
    FROM students s
    INNER JOIN users u ON s.UserID = u.UserID
    WHERE u.UserID = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("User data not found.");
}

$stmt->close();
$conn->close();

// static data
// $_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour Bassem';
// $_SESSION['address'] = isset($_POST['address']) ? $_POST['address'] : 'El Sherouk';
// $_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : 'nour@gmail.com';
// $_SESSION['department'] = isset($_POST['department']) ? $_POST['department'] : 'No department';
// $_SESSION['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '+1 (609) 972-22-22';

//career development tasks
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        <?php include "../../public/assets/styles/userDashboard.css"; ?>
    </style>
</head>
<body>

    <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
    </nav>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="pos-sidebar">
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Progress</a>
            <a href="bookCounselors.php">Book with Counsellors</a>
            <a href="InterviewSimulator.php">Interview Guide</a>
            <a href="ResumeReview.php">Submit CV for Review</a>
            <a href="forum.php">Discussion Forum</a>
        </div>
    </div>

    <main class="main-content">
        <div class="greeting">Hey <?php echo htmlspecialchars($userData['name']); ?>!</div>

        <!-- Article slider -->
        <div class="slider-container">
            <span class="arrow arrow-left" onclick="plusDivs(-1)">&#10094;</span>
            <div class="slides">
                <div class="slide banner"><img src="../../public/assets/images/article1.png" alt="art1"></div>
                <div class="slide banner"><img src="../../public/assets/images/article2.png" alt="art2"></div>
                <div class="slide banner"><img src="../../public/assets/images/article3.png" alt="art3"></div>
            </div>
            <span class="arrow arrow-right" onclick="plusDivs(1)">&#10095;</span>
            <div class="dots-container">
                <span class="dot" onclick="currentDiv(1)"></span>
                <span class="dot" onclick="currentDiv(2)"></span>
                <span class="dot" onclick="currentDiv(3)"></span>
            </div>
        </div>

    <!-- Profile completion -->
    <div class="content-grid">
        <div class="left-column">
            <div class="profile-completion">
                <h3>Complete your profile</h3>
                <div class="percentage-container">
                    <div class="percentage-bar" style="background: lightgray;">
                        <div class="percentage" style="background: #3366cc;"></div>
                    </div>
                    <span class="complete-percentage">86%</span>
                </div>
            </div>

            <!-- Profile section -->
            <div class="profile-box">
                <h3>Profile</h3>
                <div class="profile-section">
                    <h4>About</h4>
                    <div class="profile-item">
                        <img src="../../public/assets/images/profile.png" alt="Profile Icon">
                        <span><?php echo htmlspecialchars($userData['name']); ?></span>
                    </div>
                    <div class="profile-item">
                        <img src="../../public/assets/images/department.png" alt="Department Icon">
                        <span><?php echo htmlspecialchars($userData['department']); ?></span>
                    </div>
                    <div class="profile-item">
                        <img src="../../public/assets/images/location.png" alt="Location Icon">
                        <span><?php echo htmlspecialchars($userData['address']); ?></span>
                    </div>
                </div>
                <div class="profile-section">
                    <h4>Contacts</h4>
                    <div class="profile-item">
                        <img src="../../public/assets/images/email.png" alt="Email Icon">
                        <span><?php echo htmlspecialchars($userData['email']); ?></span>
                    </div>
                    <div class="profile-item">
                        <img src="../../public/assets/images/phone.png" alt="Phone Icon">
                        <span><?php echo htmlspecialchars($userData['phone']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column for career tasks and connections -->
        <div class="right-column">
        <div class="progress-box">
    <h3>Career Development Tasks</h3>
    <?php foreach ($tasks as $index => $task): ?>
        <div class="task-item">
            <div class="task-icon <?php echo $task['status'] === 'completed' ? 'completed' : ''; ?>">
                <?php echo htmlspecialchars($task['icon']); ?>
            </div>
            <div class="task-content">
                <div class="task-title"><?php echo htmlspecialchars($task['title']); ?></div>
                <div class="task-description"><?php echo htmlspecialchars($task['description']); ?></div>
                <div class="task-status">
                    <?php if ($task['status'] === 'completed'): ?>
                        Completed
                    <?php else: ?>
                        <?php
                        $links = [
                            "ResumeReview.php",
                            null, 
                            "InterviewSimulator.php",
                            "forum.php"
                        ];
                        $link = $links[$index] ?? "#";
                        ?>
                        <a href="<?php echo $link; ?>" class="start-now-btn">Start Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
            </div>

            <!-- Connections section -->
            <div class="connections-box">
                <div class="connections-header">
                    <h3>Counsellors Connections</h3>
                    <a href="bookCounselors.php" class="view-all-counsellors">View all counsellors</a>
                </div>
                <div class="connections-container">
                    <button class="scroll-btn scroll-left">&lt;</button>
                    <div class="connections-list">
                        <?php foreach ($connections as $connection): ?>
                            <div class="connection-item">
                                <div class="connection-avatar">
                                    <img src="../../public/assets/images/profile.png" alt="<?php echo htmlspecialchars($connection['name']); ?>">
                                </div>
                                <div class="connection-content">
                                    <div class="connection-name"><?php echo htmlspecialchars($connection['name']); ?></div>
                                    <div class="connection-info"><?php echo htmlspecialchars($connection['connections']); ?> connections</div>
                                </div>
                                <button class="connect-btn" data-status="<?php echo $connection['status']; ?>">
                                    <?php echo $connection['status'] === 'connected' ? '✓' : '+'; ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="scroll-btn scroll-right">&gt;</button>
                </div>
            </div>
        </div>
    </div>
    </main>
</div>


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


