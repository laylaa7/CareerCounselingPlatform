<?php
session_start();

// Simulating data retrieval from login/signup form
$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour Bassem';
$_SESSION['address'] = isset($_POST['address']) ? $_POST['address'] : 'El Sherouk';
$_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : 'nour@gmail.com';
$_SESSION['department'] = isset($_POST['department']) ? $_POST['department'] : 'No department';
$_SESSION['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '+1 (609) 972-22-22';

// Simulating data for career development tasks
$tasks = [
    [
        'icon' => '1',
        'title' => 'Complete Career Assessment',
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
        'title' => 'Virtual Internship Program',
        'description' => 'Take multiple careers for a test-drive and understand the inner workings of each profession',
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
    <!-- <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css"> -->
    <style>
        <?php include "../../public/assets/styles/userDashboard.css" ?>
    </style>
</head>
<body>
<nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>


    <div class="dashboard-container">
        <div class="sidebar">
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Progress</a>
            <a href="#">Book with Counsellors</a>
            <a href="#">Interview Guide</a>
            <a href="#">Submit CV for Review</a>
            <a href="#">Discussion Forum</a>
        </div>

    <main class="main-content">
        <div class="greeting">Hey <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</div>

    <!-- article sliders -->
    <div class="slider-container">
            <button class="arrow arrow-left" onclick="plusDivs(-1)">&#10094;</button>
        <div class="slides">
            <div class="slide banner">Develop strategies for achieving their goals</div>
            <div class="slide banner">Build a satisfying and successful career</div>
            <div class="slide banner">Navigate the job market</div>
        </div>
        <button class="arrow arrow-right" onclick="plusDivs(1)">&#10095;</button>
        <div class="dots-container">
            <span class="dot" onclick="currentDiv(1)"></span>
            <span class="dot" onclick="currentDiv(2)"></span>
            <span class="dot" onclick="currentDiv(3)"></span>
        </div>
    </div>

    
<!-- content boxes -->
<div class="content-grid">
    <div class="left-column">
            
        <div class="profile-completion">
                <h5>Complete your profile</h5>
            <div class="percentage-container">
                <div class="percentage-bar" style="background: lightgray;">
                <div class="percentage" style="background: #3366cc;"></div>
            </div>
                <span class="complete-percentage">86%</span>
                </div>
        </div>

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
                <span><?php echo htmlspecialchars($_SESSION['department']); ?></span>
            </div>
            <div class="profile-item">
                <img src="../../public/assets/images/location.png" alt="Location Icon">
                <span><?php echo htmlspecialchars($_SESSION['address']); ?></span>
            </div>
            </div>
            <div class="profile-section">
                <h3>Contacts</h3>
                <div class="profile-item">
                    <img src="../../public/assets/images/email.png" alt="Email Icon">
                    <span><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                </div>
                <div class="profile-item">
                    <img src="../../public/assets/images/phone.png" alt="Phone Icon">
                    <span><?php echo htmlspecialchars($_SESSION['phone']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="right-column">

        <div class="progress-box">
            <h5>Career Development Tasks</h5>
        <?php foreach ($tasks as $task): ?>
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
                            <button class="start-now-btn">Start Now</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="view-more">
                <a href="#">View more <img src="../../public/assets/images/right-arrow.png" alt="arrow Icon"></a>
            </div>
        </div>


<div class="connections-box">
    <div class="connections-header">
        <h5>Counsellors Connections</h5>
        <a href="bookCouncelors.php" class="view-all-counsellors">View all counsellors <img src="../../public/assets/images/right-arrow.png" alt="arrow Icon"></a>
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



