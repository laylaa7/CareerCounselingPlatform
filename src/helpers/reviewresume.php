<?php
require_once '../../controller/resumereview.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate POST data
    if (!isset($_POST['resume_id']) || !isset($_POST['feedback']) || !isset($_POST['counselor_id'])) {
        header("Location: dashboard.php?error=missing_data");
        exit();
    }

    // Sanitize inputs
    $resume_id = filter_var($_POST['resume_id'], FILTER_SANITIZE_NUMBER_INT);
    $counselor_id = filter_var($_POST['counselor_id'], FILTER_SANITIZE_NUMBER_INT);
    $feedback = htmlspecialchars($_POST['feedback']);

    // Validate feedback is not empty
    if (empty($feedback)) {
        header("Location: dashboard.php?error=empty_feedback");
        exit();
    }

    // Initialize controller and process review submission
    $controller = new ReviewController();
    $controller->submitReviewWithoutSession($resume_id, $counselor_id, $feedback);
}
?>