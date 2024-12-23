<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'dp.php';

header('Content-Type: application/json'); // Ensure JSON response

$userId = 1; // Replace with dynamic user ID based on authentication/session

try {
    $stmt = $pdo->prepare("SELECT * FROM private_discussions WHERE user_id = ?");
    $stmt->execute([$userId]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
        echo json_encode(['error' => 'No private discussions found.']);
    } else {
        echo json_encode($data);
    }
} catch (Exception $e) {
    http_response_code(500); // Set HTTP status code to 500 for server error
    echo json_encode(['error' => 'Error fetching private discussions: ' . $e->getMessage()]);
}
?>
