<?php


require_once '../helpers/routing.php';

// Instantiate the Router
$router = new Router();

// Define routes for appointments
$router->get('/counselor/dashboard', 'AppointmentsController@index');
$router->post('/appointments/changeStatus', 'AppointmentsController@changeStatus');

// Handle the incoming request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Route the request to the correct controller and method
$router->handleRequest($requestUri, $requestMethod);





 // edit to routes

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load required files
require_once '../src/config/database.php';
require_once '../src/controller/simulatorController.php';

// Initialize controller
$controller = new QuestionController($db);
// Handle main page and questions display
$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    // Display questions for the selected category
    $controller->displayQuestions($category);
    require_once '../src/view/simulator.php';

} else {
    // Display welcome page with category selection
    require_once '../src/view/category.php';
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












?>




