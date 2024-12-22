<?php

require_once __DIR__ . '/../model/User.php';

header('Content-Type: application/json'); // Enforce JSON responses
ini_set('display_errors', 0); // Suppress error output
ini_set('log_errors', 1);    // Log errors to a file
error_reporting(E_ALL);      // Log all errors and warnings
ini_set('error_log', __DIR__ . '/../logs/php-error.log'); // Define log file

class UserController {
    public function index(){
        include_once PROJECT_ROOT . '/view/home/index.php';
    }
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            if ($action === 'login') {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $this->login($email, $password);
            } elseif ($action === 'signup') {
                $fullName = $_POST['fullName'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $this->signup($fullName, $email, $password);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid action'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function login() {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
    
        if (!$username || !$password) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Username and Password are required.'
            ]);
            return;
        }
    
        $userModel = new User();
        $user = $userModel->authenticateUser($username, $password);
    
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_role'] = $user['User_Role'];
    
            echo json_encode([
                'status' => 'success',
                'role' => $user['User_Role']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid credentials.'
            ]);
        }
    }
    // Signup function with role 0
    public function signup() {
        $username = $_POST['signupUsername'] ?? null;
        $email = $_POST['signupEmail'] ?? null;
        $password = $_POST['signupPassword'] ?? null;
    
        if (!$username || !$email || !$password) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
            return;
        }
    
        $userModel = new User();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        try {
            $success = $userModel->register($username, $email, $hashedPassword, 0);
    
            if ($success) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Signup successful!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Database error: Could not complete signup.'
                ]);
            }
        } catch (Exception $e) {
            error_log("Error during signup: " . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }
}
// Handle incoming requests
$controller = new UserController();
$controller->handleRequest();