<?php
require 'dp.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 1;  // Default user ID for now

    // Validate input
    if (empty($title) || empty($description)) {
        echo "Title and description cannot be empty.";
        exit;
    }

    try {
        // Insert the discussion into the discussions table
        $sql = "INSERT INTO discussions (title, description, user_id, created_at) VALUES (:title, :description, :user_id, NOW())";
        $stmt = $pdo->prepare($sql);

        // Execute the statement
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
