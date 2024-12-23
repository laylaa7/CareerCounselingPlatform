<?php

use PHPUnit\Framework\TestCase;
require_once 'db.php';
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


class UserTest extends TestCase {
    private $user;

    protected function setUp(): void {
        $this->user = new User();

        // Create a mock database connection for testing (optional)
        $this->createTestDatabase();
    }
    

    protected function createTestDatabase(): void {
        // Create a users table in the test database
        $db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                Username VARCHAR(255) NOT NULL,
                Email VARCHAR(255) NOT NULL UNIQUE,
                Password VARCHAR(255) NOT NULL,
                User_Role INT DEFAULT 0,
                Date_Created DATE
            );
        ");
        // Insert mock data
        $db->exec("
            INSERT INTO users (Username, Email, Password, User_Role, Date_Created) 
            VALUES ('testuser', 'test@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "', 0, CURDATE());
        ");
    }

    protected function tearDown(): void {
        // Clean up the test database after each test
        $db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
        $db->exec("DROP TABLE IF EXISTS users");
    }

    public function testAuthenticateUserSuccess(): void {
        $result = $this->user->authenticateUser('test@example.com', 'password123');
        $this->assertIsArray($result, 'Authentication should return an array on success');
        $this->assertEquals('testuser', $result['Username'], 'Authenticated user should match the expected username');
    }

    public function testAuthenticateUserFailure(): void {
        $result = $this->user->authenticateUser('test@example.com', 'wrongpassword');
        $this->assertFalse($result, 'Authentication should return false for invalid credentials');
    }

    // public function testRegisterSuccess(): void {
    //     $result = $this->user->register('newuser', 'new@example.com', 'newpassword123');
    //     $this->assertTrue($result, 'Register should return true on successful registration');

        
    //     // Verify the user is inserted in the database
    //     $db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    //     $stmt = $db->prepare("SELECT * FROM users WHERE Email = :email");
        
    //     $stmt->bindParam(':email', $email = 'new@example.com');
    //     $stmt->execute();
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //     $this->assertNotNull($user, 'Newly registered user should exist in the database');
    //     $this->assertEquals('newuser', $user['Username'], 'The registered username should match the expected value');
    // }

    // public function testRegisterFailure(): void {
    //     // Try to register with an existing email
       
        
    //     $result = $this->user->register('testuser', 'test@example.com', 'password123');
    //     $this->assertFalse($result, 'Register should return false for duplicate email');
    // }
}