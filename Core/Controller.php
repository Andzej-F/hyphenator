<?php

namespace Core;

/**
 * Base controller
 * 
 * PHP version 8.0.7
 */
abstract class Controller
{
    /**
     * Parameters from the matched route(command)
     * @var array
     */
    protected $route_params = [];

    /**
     * Class' constructor
     * 
     * @param array $route_params Parameters from the route
     * 
     * @return void  
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
}
