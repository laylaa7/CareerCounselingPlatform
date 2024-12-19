<?php
include '../helpers/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? 'Anonymous';
    $comment_text = $_POST['comment_text'] ?? '';
    $post_id = $_POST['post_id'] ?? 0;

    if (empty($comment_text) || empty($post_id)) {
        echo "Comment text or post ID is missing.";
        exit;
    }

    // Use 'created_at' instead of 'timestamp'
    $stmt = $conn->prepare("INSERT INTO comments (username, comment_text, post_id, created_at) VALUES (?, ?, ?, NOW())");
    if (!$stmt) {
        echo "Database error: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ssi", $username, $comment_text, $post_id);

    if ($stmt->execute()) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
