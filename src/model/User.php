<?php

require_once 'Database.php';

class User {
    // Authenticate user (login)
    public function authenticateUser($email, $password) {
        $db = Database::getConnection();
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            return $user;
        }

        return false;
    }

    // Register new user (signup)
    public function registerUser($fullName, $email, $password, $role) {
        $db = Database::getConnection();
        $query = "INSERT INTO users (Username, Email, Password, User_Role) VALUES (:fullName, :email, :password, :role)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }
}