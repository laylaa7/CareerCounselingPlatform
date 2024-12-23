<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load required files
//require_once '../src/config/database.php';
require_once 'db.php';
require_once '../controller/simulatorController.php';

// Initialize controller
$controller = new QuestionController($db);
// Handle main page and questions display
$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    // Display questions for the selected category
    $controller->displayQuestions($category);
    require_once '../view/simulator.php';

} else {
    // Display welcome page with category selection
    require_once '../view/category.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'save-answer') {
    $studentId = $_POST['studentId'] ?? null;
    $simulatorId = $_POST['simulatorID'] ?? null;
    $answers = $_POST['answers'] ?? null;

    if ($studentId && $simulatorId && is_array($answers)) {
        foreach ($answers as $questionId => $answer) {
            if (!empty($answer)) {
                $controller->saveAnswer($simulatorId, $studentId, $questionId, $answer);
            }
        }

        // Redirect to avoid resubmission
        //header("Location: /index.php?route=simulation-results&simulatorID=$simulatorId");
        exit;
    } else {
        echo "Error: Missing required fields.";
    }
}





// $request = $_SERVER['REQUEST_URI'];
// $viewDir = '../src/pages/';

// switch ($request) {
//     case '':
//     case '/':
//         require __DIR__ . $viewDir . 'home.php';
//         break;

//     case '/views/users':
//         require __DIR__ . '../src/pages/userDashboard.php';
//         break;

//     case '/contact':
//         require __DIR__ . $viewDir . 'contact.php';
//         break;

//     default:
//         http_response_code(404);
//         require __DIR__ . $viewDir . '404.php';
// }
?>