<?php

use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Server\Router;
use Simonking\Xkphp2\Handlers\HelloWorldHandler;
use Simonking\Xkphp2\Handlers\FastHandler;

/**
 * Configure routes for the application
 * 
 * @param Router $router The router instance
 * @return void
 */
function configureRoutes(Router $router): void
{
    // Create a shared HTTP client instance
    $httpClient = HttpClientBuilder::buildDefault();
    
    // Define all application routes here
    $router->addRoute('GET', '/hello', new HelloWorldHandler());
    $router->addRoute('GET', '/api/users', new FastHandler($httpClient));
}