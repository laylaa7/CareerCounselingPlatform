<?php

// Routing logic for POST requests
require "../helpers/db_connect.php";
include_once "../controller/appointment_controller.php";

$appointmentsController = new AppointmentsController($conn);

// Front controller or route handler
$requestUri = $_SERVER['REQUEST_URI'];
// Check for matching POST request for changeStatus route
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentsController->changeStatus($_POST['appointment_id'], $_POST["status"]);
} else {
    echo "Route not found.";
}
