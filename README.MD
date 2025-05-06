# xkphp2 - Amphp HTTP Server Application

A high-performance asynchronous HTTP server built with Amphp, offering non-blocking I/O operations and event-driven architecture.

## Features

- Asynchronous request handling
- Modern PHP 8.4 syntax
- Dockerized environment
- Structured routing system
- PSR-3 compatible logging

## Requirements

- PHP 8.4 or higher
- Composer
- Docker (optional, for containerized deployment)

## Installation

### Local Development

1. Clone the repository:
   ```
   git clone https://github.com/erlangxk/xkphp2.git
   cd xkphp2
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Run the server:
   ```
   php index.php
   ```

4. Access the server at http://localhost:1337/hello

### Using Docker

1. Build and start the container:
   ```
   docker-compose up -d
   ```

2. Access the server at http://localhost:1337/hello

3. View logs:
   ```
   docker-compose logs -f
   ```

4. Stop the container:
   ```
   docker-compose down
   ```

## Project Structure

<pre>
xkphp2/
├── src/                  # Application source code
│   └── Handlers/         # Request handler classes
├── composer.json         # Composer dependencies
├── docker-compose.yml    # Docker Compose configuration
├── Dockerfile            # Docker build instructions
├── index.php             # Application entry point
├── routes.php            # Route definitions
└── README.md             # This file
</pre>

## Adding Routes

To add new routes, edit the `routes.php` file:

```php
function configureRoutes(Router $router): void
{
    // Add your routes here
    $router->addRoute('GET', '/hello', new HelloWorldHandler());
    $router->addRoute('GET', '/api/users', new UserListHandler());
}
```

## Creating Handlers

Create a new handler class in the Handlers directory:

```php
<?php
namespace Simonking\Xkphp2\Handlers;

use Amp\Http\HttpStatus;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;

class NewFeatureHandler implements RequestHandler
{
    public function handleRequest(Request $request): Response
    {
        return new Response(
            status: HttpStatus::OK,
            headers: ['Content-Type' => 'application/json'],
            body: json_encode(['data' => 'New feature response'])
        );
    }
}
```

Then add the route in routes.php:

```php
$router->addRoute('GET', '/new-feature', new NewFeatureHandler());
```

## Performance testing

install hey, https://github.com/rakyll/hey

run the following command to test the performance of the server:

```bash
hey -n 1000 -c 125 http://localhost:1337/api/users
```


## License

MIT
