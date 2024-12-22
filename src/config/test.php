<?php
require_once __DIR__ . '/Database.php';

try {
    $db = (new Database())->connect();
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>