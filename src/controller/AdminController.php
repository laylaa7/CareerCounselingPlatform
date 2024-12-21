<?php

require_once '../src/model/user_model.php';
require_once '../src/model/appointment_model.php';

class AdminController {

    // Admin Dashboard
    public function dashboard() {
       
        include '../src/view/admin/AdminDash.php';
    }

    // Admin Counselors List
    public function counselors() {
        $db = Database::getConnection();
        $userModel = new UserModel($db);
        $counselors = $userModel->getCounselors(); // Fetch counselors from the model

        include '../src/view/admin/AdminCounselors.php';
    }

    // Admin User List
    public function userList() {
        $db = Database::getConnection();
        $userModel = new UserModel($db);
        $users = $userModel->getUsers(); // Fetch users from the model

        include '../src/view/admin/AdminUserList.php';
    }
}

?>
