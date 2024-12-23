<?php
$host = 'localhost';
$db = 'test'; // Update to the correct database name
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch discussions with all necessary details
$sql = "SELECT id, title, description, user_id FROM discussions"; // Include `id` to uniquely identify each discussion
$result = $conn->query($sql);

$discussions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discussions[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($discussions);
?>
