<?php
session_start();

// Placeholder values if session variables are not set
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin';
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Not provided';
$phone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'Not provided';

// Example connections data (you can replace this with dynamic data from the database)
$connections = [
    ['name' => 'Rachel Doe', 'connections' => 25, 'image' => 'default.png', 'status' => 'connected'],
    ['name' => 'Isabella Finley', 'connections' => 79, 'image' => 'isabella.jpg', 'status' => 'pending'],
    ['name' => 'David Harrison', 'connections' => 0, 'image' => 'david.jpg', 'status' => 'connected'],
    ['name' => 'Costa Quinn', 'connections' => 9, 'image' => 'costa.jpg', 'status' => 'pending']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../../public/assets/styles/userDashboard.css"> 
  
</head>
<body>
    <nav class="navbar">
        <?php include "../../../tests/AdminNav.php"; ?>
    </nav>

    <div class="dashboard-container">
        <div class="sidebar">
            <a href="../../../src/view/admin/AdminCouselors.php">Counselors List</a>
            <a href="AdminUserList.php">Students List</a>
            <a href="AdminUserList.php">Discussions List</a>
        </div>

        <main class="main-content">
            <div class="greeting">Hey <?php echo $username; ?>!</div>

            <div class="content-grid">
                <div class="left-column">
                    <div class="profile-box">
                        <h5>Profile</h5>
                        <div class="profile-section">
                            <h3>About</h3>
                            <div class="profile-item">
                                <img src="../../../public/assets/images/default-avatar.png" alt="Profile Icon">
                                <span><?php echo $name; ?></span>
                            </div>
                            <div class="profile-item">
                                <img src="../../../public/assets/images/department.png" alt="Department Icon">
                                <span>Admin</span>
                            </div>
                            <div class="profile-item">
                                <img src="../../../public/assets/images/location.png" alt="Location Icon">
                                <span>Cairo</span>
                            </div>
                        </div>
                        <div class="profile-section">
                            <h3>Contacts</h3>
                            <div class="profile-item">
                            <img src="../../../public/assets/images/email.png" alt="Email Icon">
                                <span>Admin@gmail.com</span>
                            </div>
                            <div class="profile-item">
                            <img src="../../../public/assets/images/phone.png" alt="Phone Icon">
                                <span><?php echo $phone; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                
        </main>
    </div>

    
</body>
</html>