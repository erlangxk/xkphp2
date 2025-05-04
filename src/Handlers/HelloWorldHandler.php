<?php

namespace Simonking\Xkphp2\Handlers;

use Amp\Http\HttpStatus;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;

class HelloWorldHandler implements RequestHandler
{
    public function handleRequest(Request $request): Response
    {
        return new Response(
            status: HttpStatus::OK,
            headers: ['Content-Type' => 'text/plain'],
            body: 'Hello, world! Amphp better',
        );
    }
}