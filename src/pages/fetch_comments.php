<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "careercounseling"); // Update to the correct database name

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the `post_id` is received properly
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

// Use a prepared statement to fetch comments
$sql = "SELECT username, comment_text, DATE_FORMAT(created_at, '%Y-%m-%dT%H:%i:%s') AS created_at FROM comments WHERE post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode($comments);
$conn->close();
?>
