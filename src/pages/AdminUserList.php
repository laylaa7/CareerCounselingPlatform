<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
        <?php include "../../public/assets/styles/bookCounselors.css"; ?>
    </style>
</head>
<body class="body">

<nav class="navbar">
    <?php include "../../tests/Navbar.php"; ?>
</nav>

<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "users");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$counselors = [];
$errorMessage = "";

// Handle Add or Update Counselor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $userRole = trim($_POST['userRole']);

    if (isset($_POST['add_user'])) {
        // Validate input fields
        if (empty($username) || empty($email) || empty($userRole)) {
            $errorMessage = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Please enter a valid email address.";
        } else {
            // Check if username already exists
            try {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $errorMessage = "The username already exists. Please choose a different one.";
                } else {
                    // Insert new user
                    $stmt = $conn->prepare("INSERT INTO users (username, email, userRole) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $email, $userRole);
                    $stmt->execute();
                    $successMessage = "User added successfully!";
                }
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error adding user: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['edit_user'])) {
        $original_username = trim($_POST['original_username']);
        
        if (empty($username) || empty($email) || empty($userRole)) {
            $errorMessage = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Please enter a valid email address.";
        } else {
            // Check if new username already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND username != ?");
            $stmt->bind_param("ss", $username, $original_username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errorMessage = "The username already exists. Please choose a different one.";
            } else {
                // Update user information
                $stmt = $conn->prepare("UPDATE users SET username=?, email=?, userRole=? WHERE username=?");
                $stmt->bind_param("ssss", $username, $email, $userRole, $original_username);
                if ($stmt->execute()) {
                    $successMessage = "User updated successfully!";
                } else {
                    $errorMessage = "Error updating user: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}

// Handle Delete Counselor
if (isset($_GET['delete'])) {
    $username = $_GET['delete']; // Get the username from the query parameter
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind as a string
    $stmt->execute();
}

// Fetch all counselors
$query = "SELECT * FROM users";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $counselors[] = $row;
    }
} else {
    echo "No counselors found.";
}
?>

<div class="counselors-container">
    <a href="AdminDash.php" class="back-button">← Back to Dashboard</a>
    <h1 class="career-title">Users</h1>

    <!-- Add/Edit Form -->
    <form method="POST" class="counselor-form">
        <input type="hidden" name="id" id="counselorId">
        <input type="hidden" name="original_username" id="originalUsername" value="">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="text" name="userRole" id="userRole" placeholder="User Role" required>

        <button type="submit" name="add_user" class="book-btn add-btn">Add</button>
        <button type="submit" name="edit_user" class="book-btn edit-btn" style="display:none;">Done</button>

    </form>

    <!-- Display Counselors -->
    <div class="counselors-list">
        <?php foreach ($counselors as $counselor): ?>
            <div class="counselor-row">
                <img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">
                <div class="counselor-info">
                    <div class="name"><?= htmlspecialchars($counselor["username"]) ?></div>
                    <div class="email"><?= htmlspecialchars($counselor["Email"]) ?></div>
                    <div class="userRole"><?= htmlspecialchars($counselor["userRole"]) ?></div>

                    <!-- Action Buttons -->
                    <button class="book-btn edit-btn" onclick="editCounselor(<?= htmlspecialchars(json_encode($counselor)) ?>)">Edit</button>
                    <a href="?delete=<?= $counselor['username'] ?>" class="delete-btn book-btn" onclick="return confirm('Are you sure you want to delete this counselor?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function validateForm() {
    let username = document.getElementById('username').value.trim();
    let email = document.getElementById('email').value.trim();
    let userRole = document.getElementById('userRole').value.trim();

    if (!username || !email || !userRole) {
        alert("All fields are required.");
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    return true;
}


function editCounselor(counselor) {
    document.getElementById('username').value = counselor.username;
    document.getElementById('email').value = counselor.Email;
    document.getElementById('userRole').value = counselor.userRole;
    document.getElementById('originalUsername').value = counselor.username;

    // Change button visibility and labels
    document.querySelector('.add-btn').style.display = 'none';
    document.querySelector('.edit-btn').style.display = 'inline-block';
}
</script>

</body>
</html>
