<?php
session_start();

// Assuming these session variables are set when the user logs in
$_SESSION['first_name'] = 'Nour';
$_SESSION['last_name'] = 'B';
$_SESSION['user_logo'] = 'path_to_user_logo.png'; // This should be the path to the user's logo stored in the database

//Assuming the users name is stored in session after login
$_SESSION['first_name'] = 'Nour'; //This should be set when the user logs in

function getArticles() {
   // Simulate an array of career counseling articles
    return [
        "The Benefits of Career Counseling",
        "How to Succeed in Job Interviews",
        "Top 5 Skills Employers Look For",
        "Why Career Guidance is Essential for Growth"
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
</head>
<body>
    <nav class="navbar">
          <!-- <?php include "NavBar.php"; ?>   -->
    </nav>

        <div class="container">
            <div class="sidebar">
                <a href="#">Dashboard</a>
                <a href="#">Progress</a>
                <a href="#">Counsellors to book with</a>
                <a href="#">Interview Guide</a>
                <a href="#">Submit CV for Review</a>
                <a href="#">Discussion Forum</a>
            </div>
    
            <div class="main-content">
                <div class="greeting">Hey Nour!</div>

            <!-- Articles slider -->
            <div class="w3-content w3-display-container" style="max-width:800px; position: relative;">
            <div class="mySlides banner art1">Develop strategies for achieving their goals</div>
            <div class="mySlides banner art2" >Build a satisfying and successful career </div>
            <div class="mySlides banner art3">Navigate the job market</div>

            <div class="w3-left w3-hover-text-khaki arrow-left" onclick="plusDivs(-1)">&#10094;</div>
            <div class="w3-right w3-hover-text-khaki arrow-right" onclick="plusDivs(1)">&#10095;</div>

            <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle dots-container">
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
            </div>
            </div>


            <div class="clearfix">
                <div class="profile-completion">
                    <span>Complete your profile</span>
                    <div class="progress-bar"></div>
                    </div>
                    <div class="activity-stream-box">
                        <span>Activity stream</span>
                    </div>
                </div>
                <div class="profile-box">
                    <span>Profile</span>
                </div>
            </div>
        </div>
    
    </body>

<!-- Slider script -->
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
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}
</script>

</html>
    