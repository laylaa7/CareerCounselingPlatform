
<?php
// Include necessary files
require_once '../../controller/resumereview.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate file upload
    if (!isset($_FILES['resume'])) {
        header("Location: ../view/resumereview.php?error=no_file");
        exit();
    }

    // Get student ID from form
    $student_id = filter_var($_POST['student_id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Validate file type
    $allowed_types = ['application/pdf'];
    $file_type = $_FILES['resume']['type'];
    if (!in_array($file_type, $allowed_types)) {
        header("Location: ../view/resumereview.php?error=invalid_type");
        exit();
    }

    // Validate file size (5MB max)
    $max_size = 5 * 1024 * 1024; // 5MB in bytes
    if ($_FILES['resume']['size'] > $max_size) {
        header("Location: ../view/resumereview.php?error=file_too_large");
        exit();
    }

    // Initialize controller and process upload
    $controller = new ResumeController();
    $controller->uploadWithoutSession($student_id, $_FILES['resume']);
}

?>