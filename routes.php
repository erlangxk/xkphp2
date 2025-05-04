<?php

use Amp\Http\Server\Router;
use Simonking\Xkphp2\Handlers\HelloWorldHandler;

/**
 * Configure routes for the application
 * 
 * @param Router $router The router instance
 * @return void
 */
function configureRoutes(Router $router): void
{
    // Define all application routes here
    $router->addRoute('GET', '/hello', new HelloWorldHandler());
    
    // You can add more routes here
    // $router->addRoute('GET', '/', new HomeHandler());
    // $router->addRoute('GET', '/api/users', new UserListHandler());
    // $router->addRoute('POST', '/api/users', new CreateUserHandler());
}