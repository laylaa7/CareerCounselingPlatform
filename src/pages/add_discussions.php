<?php
require 'dp.php';
if ($pdo) {
    echo "Database connection successful.";
} else {
    echo "Database connection failed.";
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 1;  // Default user ID for now

    if (empty($title) || empty($description)) {
        echo "Title and description cannot be empty.";
        exit;
    }

    try {
        $sql = "INSERT INTO discussions (title, description, user_id) VALUES (:title, :description, :user_id)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute(['title' => $title, 'description' => $description, 'user_id' => $user_id])) {
            echo "New discussion added successfully.";
        } else {
            echo "Error adding discussion.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
