<?php

require_once __DIR__ . '/../model/Admin.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'dashboard';

        switch ($action) {
            case 'dashboard':
                $this->showDashboard();
                break;
            case 'counselors':
                $this->showCounselors();
                break;
            case 'users':
                $this->showUsers();
                break;
            default:
                echo "Invalid action.";
        }
    }

    private function showDashboard() {
        $stats = $this->adminModel->getDashboardStats();
        require __DIR__ . '../../../src/view/admin/AdminDash.php';
    }

    public function showCounselors() {
        require_once __DIR__ . '../../../src/model/Admin.php';
        $adminModel = new Admin();
        $counselors = $adminModel->getAllCounselors(); // Fetch counselors from the model
        require __DIR__ . '../../../src/view/admin/AdminCouselors.php'; // Pass to the view
    }

    private function showUsers() {
        $users = $this->adminModel->getAllUsers();
        require __DIR__ . '../../../src/view/admin/AdminUserList.php';
    }
}

// Handle incoming requests
$controller = new AdminController();
$controller->handleRequest();