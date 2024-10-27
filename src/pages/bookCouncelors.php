<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
        <?php include "../../public/assets/styles/bookCouncelors.css" ?>
    </style>
</head>
<body class="body">
<nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>


    <div class="counselors-container">
        <a href="userDashboard.php" class="back-button">← Back to Dashboard</a>
        <h1 class="career-title">Career Counselors</h1>

        <div class="counselors-list">
            <?php
            $counselors = array(
                array(
                    "name" => "Amanda Harvey",
                    "email" => "amanda@site.com",
                    "position" => "Director",
                    "department" => "Human resources",
                    "location" => "United Kingdom",
                    "status" => "active",
                    "completion" => "72",
                    "role" => "Employee",
                    "verified" => true,
                ),
                array(
                    "name" => "Anne Richard",
                    "email" => "anne@site.com",
                    "position" => "Seller",
                    "department" => "Branding products",
                    "location" => "United States",
                    "status" => "pending",
                    "completion" => "24",
                    "role" => "Employee",
                    "verified" => false,
                ),
                array(
                    "name" => "Nour bassem",
                    "email" => "nour@gmail.com",
                    "position" => "Developer",
                    "department" => "Web developer",
                    "location" => "Egypt",
                    "status" => "suspended",
                    "completion" => "100",
                    "role" => "Employee",
                    "verified" => true,
                ),
                //  rest of the counselors
            );

            foreach($counselors as $counselor) {
                echo '<div class="counselor-row">';
                
                // Image
                    echo '<img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">';

                // Counselor Info
                echo '<div class="counselor-info">';
                
                echo '<div class="name-email">';
                echo '<div class="name">' . $counselor["name"];
                if($counselor["verified"]) echo '<img src="../../public/assets/images/verified.png" class="verified-badge">';
                echo '</div>';
                echo '<div class="email">' . $counselor["email"] . '</div>';
                echo '</div>';

                echo '<div class="position">';
                echo '<div>' . $counselor["position"] . '</div>';
                echo '<div class="department">' . $counselor["department"] . '</div>';
                echo '</div>';

                echo '<div class="location">' . $counselor["location"] . '</div>';

                echo '<div class="status">';
                echo '<span class="status-dot ' . $counselor["status"] . '"></span>';
                echo ucfirst($counselor["status"]);
                echo '</div>';

                echo '<div class="completion">';
                echo $counselor["completion"] . '%';
                echo '<div class="progress-bar" style=" background-color:lightgray;">';
                echo '<div class="progress-fill" style="width: ' . $counselor["completion"] .'% "></div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="role">' . $counselor["role"] . '</div>';

                echo '
                <button class="book-btn">
                  <p class="text">Book</p>
                </button>
                ';

                echo '</div>'; 
                echo '</div>'; 
            }
            ?>
        </div>
    </div>
</body>
</html>