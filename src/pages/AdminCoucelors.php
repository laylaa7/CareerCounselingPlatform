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
    <?php include "Navbar.php"; ?>
</nav>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "trial#1"); // Object-oriented style

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

        // Check if all required fields are filled
        if (!empty($username) && !empty($age) && !empty($language) && !empty($LinkedIn) && !empty($phone) && !empty($Activity)) {
            $stmt = $conn->prepare("INSERT INTO counselors (username, age, Languages, LinkedIn, phone, Activity) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissss", $username, $age, $language, $LinkedIn, $phone, $Activity);

            if ($stmt->execute()) {
                echo "<script>alert('Counselor added successfully.');</script>"; // Notify success
            } else {
                echo "<script>alert('Error adding counselor: " . mysqli_error($conn) . "');</script>"; // Notify error
            }
            $stmt->close();
        } else {
            echo "<script>alert('Please fill in all required fields.');</script>"; // Notify missing fields
        }
    } elseif (isset($_POST['edit_counselor'])) {
        $username = $_POST['username'];
        $age = $_POST['age'];
        $language = $_POST['Languages'];
        $LinkedIn = $_POST['LinkedIn'];
        $phone = $_POST['phone'];
        $Activity = $_POST['Activity'];

        $sql = "UPDATE counselors SET age=?, LinkedIn=?, phone=?, Activity=?, Languages=? WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $age, $LinkedIn, $phone, $Activity, $language, $username);

        if ($stmt->execute()) {
            echo "<script>alert('Counselor updated successfully.');</script>"; // Notify success
        } else {
            echo "<script>alert('Error updating counselor: " . mysqli_error($conn) . "');</script>"; // Notify error
        }
        $stmt->close();
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
} else {
    echo "<script>alert('No counselors found.');</script>"; // Notify no counselors found
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
        <input type="text" name="LinkedIn" id="LinkedIn" placeholder="LinkedIn" required>
        <input type="text" name="phone" id="phone" placeholder="Phone" required>
        <input type="text" name="Activity" id="Activity" placeholder="Activity" required>

        <button type="submit" name="add_counselor" class="add-btn book-btn">Add</button>
        <button type="submit" name="edit_counselor" class="edit-btn book-btn" style="display:none;">Done</button>
    </form>

    <!-- Display Counselors -->
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
                    <a href="?delete=<?= htmlspecialchars($counselor['username']) ?>" class="delete-btn book-btn" onclick="return confirm('Are you sure you want to delete this counselor?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function editCounselor(counselor) {
    document.getElementById('counselorId').value = counselor.id; // This is not being used; consider removing
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
