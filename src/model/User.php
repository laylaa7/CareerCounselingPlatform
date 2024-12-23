<?php

require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect(); // Establish database connection
    }

    // Authenticate user (login)
    public function authenticateUser($identifier, $password) {
        try {
            // Check if identifier is email or username
            $query = filter_var($identifier, FILTER_VALIDATE_EMAIL)
                ? "SELECT * FROM users WHERE Email = :identifier"
                : "SELECT * FROM users WHERE Username = :identifier";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Password'])) {
                return $user; // Return user data if authentication succeeds
            }

            return false; // Invalid credentials
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    // Register new user (signup)
    public function register($username, $email, $password) {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // Explicitly set User_Role to 0 during signup
            $stmt = $this->db->prepare("
                INSERT INTO users (Username, Email, Password, User_Role, Date_Created)
                VALUES (:username, :email, :password, 0, CURDATE())
            ");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
