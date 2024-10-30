<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Only for development

try {
    // Update the connection details based on your XAMPP setup
    $pdo = new PDO("mysql:host=localhost;dbname=trial#1", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement to fetch skills
    $stmt = $pdo->prepare("SELECT skill_name FROM skills ORDER BY skill_name ASC");
    $stmt->execute();
    
    // Fetch the skills as a simple array of names
    $skills = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    // Send the array directly as JSON
    echo json_encode(['skills' => $skills]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
