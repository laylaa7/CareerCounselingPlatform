<?php
session_start();
$_SESSION['username'] = 'Nour';
// Simulating data retrieval from login/signup form
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$age = isset($_SESSION['age']) ? $_SESSION['age'] : 'Not provided';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : 'Not provided';
$LinkedIn = isset($_SESSION['LinkedIn']) ? $_SESSION['LinkedIn'] : 'Not provided'; 
$Activity = isset($_SESSION['Activity']) ? $_SESSION['Activity'] : 'Not provided';

// Simulating data for career development tasks
// $tasks = [
//     [
//         'icon' => '1',
//         'title' => 'Complete Career Assessment',
//         'description' => 'Your Psychometric Assessment is yet to be completed. Head over now to get one step ahead in your career planning journey',
//         'status' => 'pending'
//     ],
//     [
//         'icon' => '✓',
//         'title' => 'Fill Profile Details',
//         'description' => 'Complete your Profile Details to help us customize your guidance program',
//         'status' => 'completed'
//     ],
//     [
//         'icon' => '3',
//         'title' => 'Virtual Internship Program',
//         'description' => 'Take multiple careers for a test-drive and understand the inner workings of each profession',
//         'status' => 'pending'
//     ],
//     [
//         'icon' => '4',
//         'title' => 'Evaluate Profile',
//         'description' => 'Evaluate and enhance your profile to increase your chances of getting into your dream college',
//         'status' => 'pending'
//     ]
// ];

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
    <!-- <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css"> -->
    <style>
        <?php include "../../public/assets/styles/userDashboard.css" ?>
    </style>
</head>
<body>
<nav class="navbar">
    <?php include "../../tests/Navbar.php"; ?>
</nav>


    <div class="dashboard-container">
        <div class="sidebar">
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Insights</a>
            <a href="AdminCoucelors.php">Counsellors List</a>
            <a href="AdminUserList.php">Student List</a>
           
        </div>

    <main class="main-content">
        <div class="greeting">Hey <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>

    <!-- article sliders -->
    <!-- <div class="slider-container">
            <button class="arrow arrow-left" onclick="plusDivs(-1)">&#10094;</button>
        <div class="slides">
            <div class="slide banner"> <img src="../../public/assets/images/article1.png" alt="article1"></div>
            <div class="slide banner"> <img src="../../public/assets/images/article2.png" alt="article2"></div>
            <div class="slide banner"> <img src="../../public/assets/images/article3.png" alt="article3"></div>
        </div>
        <button class="arrow arrow-right" onclick="plusDivs(1)">&#10095;</button>
        <div class="dots-container">
            <span class="dot" onclick="currentDiv(1)"></span>
            <span class="dot" onclick="currentDiv(2)"></span>
            <span class="dot" onclick="currentDiv(3)"></span>
        </div>
    </div> -->

    
<!-- content boxes -->
<div class="content-grid">
    <!-- <div class="left-column">
            
        // <div class="profile-completion">
        //         <h5>Complete your profile</h5>
        //     <div class="percentage-container">
        //         <div class="percentage-bar" style="background: lightgray;">
        //         <div class="percentage" style="background: #3366cc;"></div>
        //     </div>
        //         <span class="complete-percentage">86%</span>
        //         </div>
        // </div> -->

        <div class="profile-box">
                <h5>Profile</h5>
            <div class="profile-section">
                    <h3>About</h3>
            <div class="profile-item">
                <img src="../../public/assets/images/profile.png" alt="Profile Icon">
                <span><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
            <div class="profile-item">
                <img src="../../public/assets/images/department.png" alt="Department Icon">
                <span>Admin</span>
            </div>
            <div class="profile-item">
                <img src="../../public/assets/images/location.png" alt="Location Icon">
                <span>Cairo</span>
            </div>
            </div>
            <div class="profile-section">
                <h3>Contacts</h3>
                <div class="profile-item">
                    <img src="../../public/assets/images/email.png" alt="Email Icon">
                    <span>Admin@gmail.com</span>
                </div>
                <div class="profile-item">
                    <img src="../../public/assets/images/phone.png" alt="Phone Icon">
                    <span>01115071166</span>
                </div>
            </div>
        </div>
    

 


<div class="connections-box">
    <div class="connections-header">
        <h5>Counsellors Connections</h5>
        <a href="AdminCoucelors.php" class="view-all-counsellors">View all counsellors <img src="../../public/assets/images/right-arrow.png" alt="arrow Icon"></a>
    </div>
    <div class="connections-container">
        <button class="scroll-btn scroll-left" aria-label="Scroll left">&lt;</button>
        <div class="connections-list">
            <?php foreach ($connections as $connection): ?>
                <div class="connection-item">
                    <div class="connection-avatar">
                        <img src="../../public/assets/images/profile.png" alt="<?php echo htmlspecialchars($connection['name']); ?>" width="60" height="60">
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
        <button class="scroll-btn scroll-right" aria-label="Scroll right">&gt;</button>
    </div>
</div>
        


    </div>


</div>
</main>
    
</body>
</html>



