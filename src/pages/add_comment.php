<?php
// Database connection
require_once 'db_connect.php'; // Update with your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $comment_text = $_POST['comment_text'] ?? null;
    $username = $_POST['username'] ?? 'GuestUser'; // Set default username to 'GuestUser' if not provided

    if ($post_id && $comment_text) {
        try {
            $stmt = $pdo->prepare("INSERT INTO comments (post_id, comment_text, username) VALUES (:post_id, :comment_text, :username)");
            $stmt->execute([
                ':post_id' => $post_id,
                ':comment_text' => $comment_text,
                ':username' => $username,
            ]);
            echo "Comment added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Missing required fields.";
    }
}
?>
