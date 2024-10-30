<?php

$host = 'localhost'; // Adjust if necessary
$db = 'discussions'; // Your database name
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, description, user_id FROM discussions"; // Adjust the query if your table structure is different
$result = $conn->query($sql);

$discussions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discussions[] = $row;
    }
}

$conn->close();

// Set the content type to JSON and return the discussions
header('Content-Type: application/json');
echo json_encode($discussions);
?>
