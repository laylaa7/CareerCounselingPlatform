<?php


require_once '../helpers/routing.php';

// Instantiate the Router
$router = new Router();

// Define routes for appointments
$router->get('/counselor/dashboard', 'AppointmentsController@index');
$router->post('/appointments/changeStatus', 'AppointmentsController@changeStatus');

// Handle the incoming request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Route the request to the correct controller and method
$router->handleRequest($requestUri, $requestMethod);
?>




