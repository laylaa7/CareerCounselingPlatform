<?php
// Example PHP code to fetch comments
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "comment_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_POST['post_id'];
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
