<?php

require_once __DIR__ . '/../config/config.php';

class Router {
    private $routes = []; //A private property that stores all the routes registered with the router

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action; 
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    //handle incoming request
    public function handleRequest($uri, $method) {
        ob_start(); // Start output buffering
    
        try {
            if (isset($this->routes[$method][$uri])) { //check if uri matches the route
                $action = explode('@', $this->routes[$method][$uri]);
                $controllerName = $action[0]; //AppoitmentsController
                $methodName = $action[1]; //index, changeStatus
    
                $controllerFile = PROJECT_ROOT . '/controller/' . $controllerName . ".php";
    
                if (file_exists($controllerFile)) { //locate controller file
                    include_once $controllerFile; 
    
                    $controller = new $controllerName(); 
    
                    if (method_exists($controller, $methodName)) { //call method
                        $refMethod = new ReflectionMethod($controller, $methodName);
                        $params = [];
                        
                        foreach ($refMethod->getParameters() as $param) {//builds a list from user input
                            $paramName = $param->getName();
                            if (isset($_REQUEST[$paramName])) {
                                $params[] = $_REQUEST[$paramName];
                            } else {
                                $params[] = $param->isOptional() ? $param->getDefaultValue() : null;
                            }
                        }
    
                        // Call the method with extracted parameters
                        $response = call_user_func_array([$controller, $methodName], $params);
                        echo $response; // Ensure the response is outputted correctly
                    } else {
                        die("Method $methodName not found in $controllerName controller.");
                    }
                } else {
                    die("Controller file $controllerFile not found.");
                }
            } else {
                die("Route not found for $method $uri");
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    
        ob_end_flush(); // Flush output buffer(display output after processing)
    }
    
    
}
