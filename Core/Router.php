<?php

namespace Core;

/**
 * Router
 * 
 * PHP version 8.0.7
 */
class Router
{
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a route/command to the routing table
     * 
     * @param string $route The route command
     * @param array $params Parameters (controller, action)
     * 
     * @return void
     */
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     * 
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match  the route to the routes in the routing table, setting
     * the $params property if a route is found.
     * 
     * @param string $command The route command
     * 
     * @return boolean true if a match found, false otherwise
     */
    public function match($command)
    {
        foreach ($this->routes as $route => $params) {
            if ($command == $route) {

                // Set the property
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Get the currently matches parameters
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Dispatch the route, creating the Controller object and
     * running the action method
     * 
     * @param string $command The route command
     * 
     * @return void
     */
    public function dispatch($command)
    {
        if ($this->match($command)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);

            if (class_exists($controller)) {
                $controller_object = new $controller();

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller $controller) not found";
                }
            } else {
                echo "Controller class $controller not found";
            }
        } else {
            echo "No route matched";
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     * 
     * @param string The string to convert
     * 
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        // Remove dashes
        $string = str_replace('-', ' ', $string);

        // Capitalise the first letter
        $string = ucwords($string);

        // Remove spaces
        $string = str_replace(' ', '', $string);

        return $string;
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }
}
