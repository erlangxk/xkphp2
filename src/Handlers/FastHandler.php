<?php

namespace Simonking\Xkphp2\Handlers;

use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request as ClientRequest;
use Amp\Http\HttpStatus;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;

class FastHandler implements RequestHandler
{
    private HttpClient $httpClient;
    
    public function __construct(HttpClient $httpClient)
    {
        // Use the provided HTTP client instance
        $this->httpClient = $httpClient;
    }
    
    public function handleRequest(Request $request): Response
    {
        try {
            // Get the target URL from query parameters, with a fallback default
            $targetUrl = $request->getQueryParameter('url') ?? 'https://jsonplaceholder.typicode.com/posts/1';
            
            // Create a new HTTP request to the target URL
            $clientRequest = new ClientRequest($targetUrl);
            
            // Perform the request and get the response
            $clientResponse = $this->httpClient->request($clientRequest);
            
            // Get the response body as a string
            $responseBody = $clientResponse->getBody()->buffer();
            
            // Return the data as JSON
            return new Response(
                status: HttpStatus::OK,
                headers: [
                    'Content-Type' => 'application/json',
                    'X-Source-Url' => $targetUrl
                ],
                body: $responseBody
            );
            
        } catch (\Throwable $e) {
            // Handle any errors
            return new Response(
                status: HttpStatus::INTERNAL_SERVER_ERROR,
                headers: ['Content-Type' => 'application/json'],
                body: json_encode([
                    'error' => 'Failed to fetch remote data',
                    'message' => $e->getMessage()
                ])
            );
        }
    }
}