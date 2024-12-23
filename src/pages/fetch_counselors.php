<?php
require 'dp.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['counselor_id'])) {
        $counselorId = $_POST['counselor_id'];

        // Fetch specific counselor details
        $stmt = $pdo->prepare("SELECT * FROM counselors WHERE CounselorID = ?");
        $stmt->execute([$counselorId]);
        $counselor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($counselor) {
            echo json_encode($counselor);
        } else {
            echo json_encode(['error' => 'Counselor not found.']);
        }
    } else {
        // Fetch all counselors
        $stmt = $pdo->query("SELECT * FROM counselors");
        $counselors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($counselors) {
            echo json_encode($counselors);
        } else {
            echo json_encode(['error' => 'No counselors found.']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching counselor details: ' . $e->getMessage()]);
}
?>
