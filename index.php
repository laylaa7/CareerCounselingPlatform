<?php

require_once 'src/helpers/routing.php';

// Instantiate the Router
$router = new Router();

// Define routes for appointments

//Pages
$router->get('/CareerCounseling/CareerCounselingPlatform/counselor/dashboard', 'AppointmentsController@index');

//API Calls
$router->post('/CareerCounseling/CareerCounselingPlatform/appointments/changeStatus', 'AppointmentsController@changeStatus');
$router->post('/CareerCounseling/CareerCounselingPlatform/appointments/delete', 'AppointmentsController@deleteAppointment');
$router->post('/CareerCounseling/CareerCounselingPlatform/appointments/filter', 'AppointmentsController@getFilteredAppointments');

// Handle the incoming request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Route the request to the correct controller and method
$router->handleRequest($requestUri, $requestMethod);

/**
 * <!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Layout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
    </nav>

    <div class="dashboard">
        <ul>
            <li><a href="index.php?page=home">Home Page</a></li>
            <li><a href="index.php?page=forum">Discussion Forum</a></li>
            <li><a href="index.php?page=counselor">Counselor Forum</a></li>

        </ul>
    </div>

    <div class="content">
        <?php
            // PHP to load different pages based on the URL parameter
            // if (isset($_GET['page'])) {
            //     $page = $_GET['page'];

            //     if ($page == 'home') {
            //         include 'home.php';
            //     } elseif ($page == 'forum') {
            //         include 'forum.php';
            //     } 
            //     elseif ($page == 'counselor') { 
            //         include 'counselor.php';
            //     }
            //     else {
            //         echo "<h2>Page not found</h2>";
            //     }
            // } else {
            //     echo "<h2>Welcome to the Home Page</h2>";
            // }
        ?>
    </div>

</body>
</html> -->

 */

?>

