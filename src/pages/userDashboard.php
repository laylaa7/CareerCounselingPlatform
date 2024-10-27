<?php
session_start();

$_SESSION['first_name'] = 'Nour';
$_SESSION['last_name'] = 'B';
$_SESSION['user_logo'] = 'path_to_user_logo.png';

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
                <div class="progress-container">
                    <div class="progress-bar" style="background:white;">
                    <div class="progress" style="background: #3366cc;"></div>
                </div>
                <span class="progress-percentage">86%</span>
                </div>
            </div>

            <div class="profile-box">
                <h5>Profile</h5>
                <!-- Add profile content here -->
            </div>
        </div>
        <div class="right-column">
            <div class="activity-stream-box">
                <h5>Activity stream</h5>
                <!-- Add activity stream content here -->
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
</script>

    
</body>
</html>



