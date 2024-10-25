<?php
session_start();

// Assuming these session variables are set when the user logs in
$_SESSION['first_name'] = 'Nour';
$_SESSION['last_name'] = 'B';
$_SESSION['user_logo'] = 'path_to_user_logo.png';

function getArticles() {
    // Simulate an array of career counseling articles
    return [
        "Develop strategies for achieving their goals",
        "Build a satisfying and successful career",
        "Navigate the job market"
    ];
}

$articles = getArticles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css">
    <link rel="stylesheet" href="../../public/assets/vendor/bootstrap-icons/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar">
        <?php include "NavBar.php"; ?>
    </nav>

    <div class="dashboard-container">
        <nav class="sidebar">
            <a href="#" class="dash">Dashboard</a>
            <a href="#" class="dash2">Progress</a>
            <a href="#">Book with Counsellors</a>
            <a href="#">Interview Guide</a>
            <a href="#">Submit CV for Review</a>
            <a href="#">Discussion Forum</a>
        </nav>

        <main class="main-content">
            <div class="greeting">Hey <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</div>

            <div class="slider-container">
                <?php foreach ($articles as $index => $article): ?>
                    <div class="slide banner art<?php echo $index + 1; ?>"><?php echo htmlspecialchars($article); ?></div>
                <?php endforeach; ?>
                <button class="arrow-left" onclick="plusDivs(-1)">&#10094;</button>
                <button class="arrow-right" onclick="plusDivs(1)">&#10095;</button>
                <div class="dots-container">
                    <?php foreach ($articles as $index => $article): ?>
                        <span class="dot" onclick="currentDiv(<?php echo $index + 1; ?>)"></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="content-grid">
                <div class="profile-completion">
                    <h3>Complete your profile</h3>
                    <div class="progress-bar"><div class="progress"></div></div>
                </div>
                <div class="activity-stream-box">
                    <h3>Activity stream</h3>
                </div>
            </div>

            <div class="profile-box">
                <h3>Profile</h3>
            </div>
        </main>
    </div>

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



