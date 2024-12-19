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

$conn = mysqli_connect("localhost", "root", "", "users");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$counselors = [];
$errorMessage = "";

// Handle Add or Update Counselor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_counselor'])) {
        $username = trim($_POST['username']);
        $age = $_POST['age'];
        $language = trim($_POST['Languages']);
        $LinkedIn = trim($_POST['LinkedIn']);
        $phone = trim($_POST['phone']);
        $Activity = trim($_POST['Activity']);

        if (empty($username) || empty($age) || empty($language) || empty($LinkedIn) || empty($phone) || empty($Activity)) {
            $errorMessage = "All fields are required.";
        } elseif ($age < 18) {
            $errorMessage = "The counselor must be at least 18 years old.";
        } elseif (!filter_var($LinkedIn, FILTER_VALIDATE_URL)) {
            $errorMessage = "Please enter a valid LinkedIn URL.";
        } elseif (!preg_match("/^\d{11}$/", $phone)) {
            $errorMessage = "Please enter a valid 11-digit phone number.";
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO counselors (username, age, Languages, LinkedIn, phone, Activity) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sissss", $username, $age, $language, $LinkedIn, $phone, $Activity);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                if (strpos($e->getMessage(), "Duplicate entry") !== false) {
                    $errorMessage = "The username already exists. Please choose a different one.";
                } else {
                    $errorMessage = "Error adding counselor: " . $e->getMessage();
                }
            } finally {
                if (isset($stmt)) $stmt->close();
            }
        }
    
    } elseif (isset($_POST['edit_counselor'])) {
        $username = trim($_POST['username']);
        $age = $_POST['age'];
        $language = trim($_POST['Languages']);
        $LinkedIn = trim($_POST['LinkedIn']);
        $phone = trim($_POST['phone']);
        $Activity = trim($_POST['Activity']);
        $original_username = trim($_POST['original_username']);

        if (empty($username) || empty($age) || empty($language) || empty($LinkedIn) || empty($phone) || empty($Activity)) {
            $errorMessage = "All fields are required.";
        } elseif ($age < 18) {
            $errorMessage = "The counselor must be at least 18 years old.";
        } elseif (!filter_var($LinkedIn, FILTER_VALIDATE_URL)) {
            $errorMessage = "Please enter a valid LinkedIn URL.";
        } elseif (!preg_match("/^\d{11}$/", $phone)) {
            $errorMessage = "Please enter a valid 11-digit phone number.";
        } else {
            // Check if the new username already exists for another user
            $stmt = $conn->prepare("SELECT * FROM counselors WHERE username = ? AND username != ?");
            $stmt->bind_param("ss", $username, $original_username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errorMessage = "The username already exists. Please choose a different one.";
            } else {
                // Update counselor information, including the username
                $stmt = $conn->prepare("UPDATE counselors SET username=?, age=?, Languages=?, LinkedIn=?, phone=?, Activity=? WHERE username=?");
                $stmt->bind_param("sisssss", $username, $age, $language, $LinkedIn, $phone, $Activity, $original_username);

                if (!$stmt->execute()) {
                    $errorMessage = "Error updating counselor: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}

// Handle Delete Counselor
if (isset($_GET['delete'])) {
    $username = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM counselors WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
}

// Fetch all counselors
$query = "SELECT * FROM counselors";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $counselors[] = $row;
    }
}
?>

<div class="counselors-container">
    <a href="AdminDash.php" class="back-button">← Back to Dashboard</a>
    <h1 class="career-title">Career Counselors</h1>

    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form method="POST" class="counselor-form" onsubmit="return validateForm()">
        <input type="hidden" name="id" id="counselorId">
        <input type="hidden" name="original_username" id="originalUsername">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="number" name="age" id="age" placeholder="Age" required>
        <input type="text" name="Languages" id="Languages" placeholder="Languages" required>
        <input type="text" name="LinkedIn" id="LinkedIn" placeholder="LinkedIn" required>
        <input type="text" name="phone" id="phone" placeholder="Phone" required>
        <input type="text" name="Activity" id="Activity" placeholder="Activity" required>

        <button type="submit" name="add_counselor" class="add-btn book-btn">Add</button>
        <button type="submit" name="edit_counselor" class="edit-btn book-btn" style="display:none;">Done</button>
    </form>

    <div class="counselors-list">
        <?php foreach ($counselors as $counselor): ?>
            <div class="counselor-row">
                <img src="../../public/assets/images/profile.png" class="profile-img" alt="Profile">
                <div class="counselor-info">
                    <div class="name"><?= htmlspecialchars($counselor["username"]) ?></div>
                    <div class="age"><?= htmlspecialchars($counselor["age"]) ?></div>
                    <div class="language"><?= htmlspecialchars($counselor["Languages"]) ?></div>
                    <div class="linkedin"><?= htmlspecialchars($counselor["LinkedIn"]) ?></div>
                    <div class="phone"><?= htmlspecialchars($counselor["phone"]) ?></div>
                    <div class="activity"><?= htmlspecialchars($counselor["Activity"]) ?></div>
                    <button class="edit-btn book-btn" onclick="editCounselor(<?= htmlspecialchars(json_encode($counselor)) ?>)">Edit</button>
                    <a href="?delete=<?= $counselor['username'] ?>" class=" book-btn"  style= " height: 6.5vh; width: 12vh;" onclick="return confirm('Are you sure you want to delete this counselor?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function validateForm() {
    let username = document.getElementById('username').value.trim();
    let age = document.getElementById('age').value;
    let languages = document.getElementById('Languages').value.trim();
    let linkedIn = document.getElementById('LinkedIn').value.trim();
    let phone = document.getElementById('phone').value.trim();
    let activity = document.getElementById('Activity').value.trim();

    if (!username || !age || !languages || !linkedIn || !phone || !activity) {
        alert("All fields are required.");
        return false;
    }
    if (age < 18) {
        alert("The counselor must be at least 18 years old.");
        return false;
    }
    const urlPattern = /^(https?:\/\/)?((www|\w\w)\.)?linkedin\.com\/.*$/;
    if (!urlPattern.test(linkedIn)) {
        alert("Please enter a valid LinkedIn URL.");
        return false;
    }
    if (!/^\d{11}$/.test(phone)) {
        alert("Please enter a valid 11-digit phone number.");
        return false;
    }
    return true;
}

function editCounselor(counselor) {
    document.getElementById('counselorId').value = counselor.id;
    document.getElementById('username').value = counselor.username;
    document.getElementById('originalUsername').value = counselor.username;
    document.getElementById('age').value = counselor.age;
    document.getElementById('Languages').value = counselor.Languages;
    document.getElementById('LinkedIn').value = counselor.LinkedIn;
    document.getElementById('phone').value = counselor.phone;
    document.getElementById('Activity').value = counselor.Activity;

    document.querySelector('.add-btn').style.display = 'none';
    document.querySelector('.edit-btn').style.display = 'inline-block';
}
</script>

</body>
</html>    