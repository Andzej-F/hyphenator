<?php

/**
 * Front controller
 * 
 * PHP version 8.0.7
 */

/**
 * Composer
 */
// require '../vendor/autoload.php';
$command = isset($argv[1]) ? $argv[1] : null;

if (isset($command)) {
    echo "Requested command is \"" . $command . "\"\n";
} else {
    echo "No command entered\n";
}
/**
 * Routing
 */
require '../Core/Router.php';
require '../App/Controllers/Home.php';
require '../App/Controllers/Hyphenation.php';

$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
// $router->add("hyph", ['controller' => 'Hyphenation', 'action' => 'index']);
if ((isset($argv[1]) && ($argv[2] === 'hyph'))) {
    $router->add("hyph", ['controller' => 'Hyphenation', 'action' => 'hyphenate', 'input' => $argv[1]]);
}
$router->add("exit", ['controller' => 'Home', 'action' => 'exit']);

// Display the routing table
// var_dump($router->getRoutes());

// Match the requested route
// if ($router->match($command)) {
//     var_dump($router->getparams());
// } else {
//     echo "No route found for command " . $command;
// }

// print_r($argv);

$router->dispatch($command);
