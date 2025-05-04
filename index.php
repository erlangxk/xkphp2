<?php
use Amp\ByteStream;
use Amp\Http\Server\DefaultErrorHandler;
use Amp\Http\Server\Router;
use Amp\Http\Server\SocketHttpServer;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/routes.php';

// Note any PSR-3 logger may be used, Monolog is only an example.
$logHandler = new StreamHandler(ByteStream\getStdout());
$logHandler->pushProcessor(new PsrLogMessageProcessor());
$logHandler->setFormatter(new ConsoleFormatter());

$logger = new Logger('server');
$logger->pushHandler($logHandler);

$errorHandler = new DefaultErrorHandler();

$server = SocketHttpServer::createForDirectAccess($logger);
$router = new Router($server, $logger, $errorHandler);

// Configure routes from the separate routes file
configureRoutes($router);

$server->expose('0.0.0.0:1337');
$server->start($router, $errorHandler);
$logger->info('Server running at http://0.0.0.0:1337');

// Serve requests until SIGINT or SIGTERM is received by the process.
$signal = Amp\trapSignal([SIGINT, SIGTERM]);

$logger->notice('Received signal {signal}, stopping server...', ['signal' => $signal]);

$server->stop();