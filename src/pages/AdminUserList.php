<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Career Counselors</title>
    <style>
        <?php include "../../public/assets/styles/bookCouncelors.css"; ?>
    </style>
</head>
<body class="body">

<nav class="navbar">
    <?php include "Navbar.php"; ?>
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
    if (isset($_POST['add_counselor'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $userRole = $_POST['userRole'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        // Prepare the SQL statement using placeholders
        if ($result->num_rows > 0) {
            // Username already exists
            $errorMessage = "Username already exists. Please choose a different username.";
        } else {
            // Prepare the SQL statement using placeholders
            $stmt = $conn->prepare("INSERT INTO users (username, Email, userRole) VALUES (?, ?, ?)");
            // Bind parameters: s = string
            $stmt->bind_param("sss", $username, $email, $userRole);

            // Execute the statement
            if ($stmt->execute()) {
                // Optional: you can echo a success message here
            } else {
                // Optional: log the error instead of displaying it
            }
        }

        $stmt->close();
    } elseif (isset($_POST['edit_counselor'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $userRole = $_POST['userRole'];

        // SQL statement to update counselor using unique username
        $sql = "UPDATE users SET email='$email', userRole='$userRole' WHERE username='$username'";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            // Optional: echo a success message here
        } else {
            echo "Error updating counselor: " . mysqli_error($conn);
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
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="text" name="userRole" id="userRole" placeholder="User Role" required>

        <button type="submit" name="add_counselor" class="book-btn add-btn">Add</button>
        <button type="submit" name="edit_counselor" class="book-btn edit-btn" style="display:none;">Done</button> <!-- Initially hidden -->
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
function editCounselor(counselor) {
    document.getElementById('username').value = counselor.username;
    document.getElementById('email').value = counselor.Email;
    document.getElementById('userRole').value = counselor.userRole;

    // Change button visibility and labels
    document.querySelector('.add-btn').style.display = 'none';
    document.querySelector('.edit-btn').style.display = 'inline-block';
}
</script>

</body>
</html>
