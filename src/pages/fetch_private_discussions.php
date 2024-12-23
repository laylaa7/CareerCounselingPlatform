<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'dp.php'; // Ensure your database connection is properly included

header('Content-Type: application/json'); // Ensure JSON response

$userId = 1; // Replace with dynamic user ID based on authentication/session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_reply') {
    // Handle reply submission
    $discussion_id = $_POST['discussion_id'] ?? null;
    $reply_text = $_POST['reply_text'] ?? null;

    // Default counselor ID is 1
    $counselor_id = 1;

    if ($discussion_id && $reply_text) {
        try {
            // Check if a reply already exists
            $stmt = $pdo->prepare("SELECT reply FROM private_discussions WHERE id = :id");
            $stmt->bindParam(':id', $discussion_id, PDO::PARAM_INT);
            $stmt->execute();
            $discussion = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($discussion && empty($discussion['reply'])) {
                // Add reply and set CounselorID
                $updateStmt = $pdo->prepare("
                    UPDATE private_discussions 
                    SET reply = :reply, CounselorID = :counselor_id 
                    WHERE id = :id
                ");
                $updateStmt->execute([
                    ':reply' => $reply_text,
                    ':counselor_id' => $counselor_id,
                    ':id' => $discussion_id,
                ]);
                echo json_encode(['success' => 'Reply added successfully!']);
            } else {
                echo json_encode(['error' => 'Reply already exists for this discussion.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Missing required fields.']);
    }
} else {
    // Fetch discussions
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
}
?>
