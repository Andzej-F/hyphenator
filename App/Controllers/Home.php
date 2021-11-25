<?php

// namespace App\Controllers;

/**
 * Home controller
 * 
 * PHP version 8.0.7
 */
class Home
{
    /**
     * Show the index page
     * 
     * @return void
     */
    public function index()
    {
        echo "Hello from the index action in the Posts controller!";
    }

    /**
     * Exit the application
     * 
     * @return void
     */
    public function exit()
    {
        exit("Application closed");
    }
}
