<?php

require_once 'models/User.php';

class UserController {
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];

            if ($action === 'login') {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $this->login($email, $password);
            } elseif ($action === 'signup') {
                $fullName = $_POST['fullName'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $this->signup($fullName, $email, $password);
            }
        }
    }

    // Login function
    public function login($email, $password) {
        $userModel = new User();
        $user = $userModel->authenticateUser($email, $password);

        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_role'] = $user['User_Role'];

            if ($user['User_Role'] == 2) {
                header('Location: AdminDash.php');
            } elseif ($user['User_Role'] == 1) {
                header('Location: CounselorDashboard.php');
            } elseif ($user['User_Role'] == 0) {
                header('Location: UserDashboard.php');
            }
        } else {
            header('Location: index.php?error=invalid_credentials');
        }
    }

    // Signup function with role 0
    public function signup($fullName, $email, $password) {
        $userModel = new User();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 0; // Default role
        $isRegistered = $userModel->registerUser($fullName, $email, $hashedPassword, $role);

        if ($isRegistered) {
            header('Location: index.php?success=signup');
        } else {
            header('Location: index.php?error=signup_failed');
        }
    }
}

// Handle incoming requests
$controller = new UserController();
$controller->handleRequest();