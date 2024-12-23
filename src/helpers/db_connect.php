<?php
$servername = "localhost";
$username = "root";
$password = "";
// [TODO] change to the new and final database name 
$dbname = "CareerCompass";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
