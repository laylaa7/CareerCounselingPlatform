


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Nav Bar with PHP</title>
    <link rel="stylesheet" href="../../public/assets/styles/UserProfile.css"> 
    
</head>
<body>

    <!-- Navigation Bar
    <nav class="navbar">
        <ul>
         <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li> 
        </ul>
    </nav> -->
    <div>
    <nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>
</div>
    <!-- Main content of the page -->
    <div class="profile-container">
    
        <!-- Left Sidebar -->
        <div class="sidebar">
            <!-- <img src="../../public/assets/images/BackButton.png" > -->
            <div class="profile-pic">
                
                <img src="../../public/assets/images/default-avatar.png" alt="Profile Picture">
            </div>
            <h2> Mohamed</h2>

            <hr>

            <ul class="profile-links">
                <li><a href="#" data-target="personal-info">Personal info</a></li>
                <li><a href="#" data-target="academic-background">Academic background</a></li>
                <li><a href="#" data-target="resume">Resume</a></li>
                <li><a href="#" data-target="career-interests">Career interests</a></li>
            </ul>
            <hr>


            <div class="logout">
                <a href="#">Log out</a>
            </div>
        </div>

        <!-- Main Profile Content -->
<div class="profile-content">
   
</div>


       
        

    </div>

    <script src="../../public/assets/scripts/UserProfile.js"></script>

</body>

</html>
