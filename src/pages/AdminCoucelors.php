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

// Handle Add or Update Counselor

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_counselor'])) {
            $username = $_POST['username'];
            $age = $_POST['age'];
            $language = $_POST['Languages'];
            $LinkedIn = $_POST['LinkedIn'];
            $phone = $_POST['phone'];
            $Activity = $_POST['Activity'];
    
            // Prepare the SQL statement using placeholders
            $stmt = $conn->prepare("INSERT INTO counselors (username, age, Languages, LinkedIn, phone, Activity) VALUES (?, ?, ?, ?, ?, ?)");
            // Bind parameters: s = string, i = integer
            $stmt->bind_param("sissss", $username, $age, $language, $LinkedIn, $phone, $Activity);
    
            // Execute the statement
            if ($stmt->execute()) {
                // You can remove this line or comment it out
                // echo "Counselor added successfully.";
            } else {
                // Optionally log the error instead of displaying it
                // echo "Error adding counselor: " . mysqli_error($conn);
            }
    
            $stmt->close();
        }
    
    elseif (isset($_POST['edit_counselor'])) {
        $username = $_POST['username'];
        $age = $_POST['age'];
        $Language = $_POST['Languages'];
        $LinkedIn = $_POST['LinkedIn'];
        $phone = $_POST['phone'];
        $Activity = $_POST['Activity'];
    
        // SQL statement to update counselor using unique username
        $sql = "UPDATE counselors SET age='$age', LinkedIn='$LinkedIn', phone='$phone', Activity='$Activity', Languages='$Language' WHERE username='$username'";
    
        // Execute query
        if (mysqli_query($conn, $sql)) {
            // Update successful
            // echo "Counselor updated successfully.";
        } else {
            // Update failed
            echo "Error updating counselor: " . mysqli_error($conn);
        }
    }
}

// Handle Delete Counselor
if (isset($_GET['delete'])) {
    $username = $_GET['delete']; // Get the username from the query parameter
    $stmt = $conn->prepare("DELETE FROM counselors WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind as a string
    $stmt->execute();
}

// Fetch all counselors
$query = "SELECT * FROM counselors";
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
    <h1 class="career-title">Career Counselors</h1>

    <!-- Add/Edit Form -->
    <form method="POST" class="counselor-form">
        <input type="hidden" name="id" id="counselorId">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="number" name="age" id="age" placeholder="Age" required>
        <input type="text" name="Languages" id="Languages" placeholder="Languages" required>
        <!-- <select name="Languages" id="Languages" required>
                    <option value="">Select Language</option>
                    <option value="English">English</option>
                    <option value="Arabic">Arabic</option>
                    <option value="French">French</option>
                    <option value="Spanish">Spanish</option>
                    <option value="German">German</option>
        </select> -->
        <input type="text" name="LinkedIn" id="LinkedIn" placeholder="LinkedIn" required>
        <input type="text" name="phone" id="phone" placeholder="Phone" required>
        <input type="text" name="Activity" id="Activity" placeholder="Activity" required>

        <button type="submit" name="add_counselor " class="add-btn book-btn">Add</button>
        <button type="submit" name="edit_counselor" class="edit-btn book-btn" style="display:none;">Done</button>
    </form>

    <!-- Display Counselors -->
    <div class="counselors-list">
        <?php foreach ($counselors as $counselor): ?>
            <div class="counselor-row">
                <img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">
                <div class="counselor-info">
                    <div class="name"><?= htmlspecialchars($counselor["username"]) ?></div>
                    <div class="email"><?= htmlspecialchars($counselor["age"]) ?></div>
                    <div class="language"><?= htmlspecialchars($counselor["Languages"]) ?></div>
                    <div class="department"><?= htmlspecialchars($counselor["LinkedIn"]) ?></div>
                    <div class="location"><?= htmlspecialchars($counselor["phone"]) ?></div>
                   
                        <span class="status-dot <?= htmlspecialchars($counselor["Activity"]) ?>"></span>
                    

                    <!-- Action Buttons -->
                    <button class="edit-btn book-btn" onclick="editCounselor(<?= htmlspecialchars(json_encode($counselor)) ?>)">Edit</button>
                    <a href="?delete=<?= $counselor['username'] ?>" class="delete-btn book-btn" onclick="return confirm('Are you sure you want to delete this counselor?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function editCounselor(counselor) {
    document.getElementById('counselorId').value = counselor.id;
    document.getElementById('username').value = counselor.username;
    document.getElementById('age').value = counselor.age;
    document.getElementById('Languages').value = counselor.Languages;
    document.getElementById('LinkedIn').value = counselor.LinkedIn;
    document.getElementById('phone').value = counselor.phone;
    document.getElementById('Activity').value = counselor.Activity;

    // Change button labels
    document.querySelector('.add-btn').style.display = 'none';
    document.querySelector('.edit-btn').style.display = 'inline-block';
}
</script>

</body>
</html>
