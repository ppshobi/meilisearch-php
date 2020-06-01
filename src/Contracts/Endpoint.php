<?php


namespace MeiliSearch\Contracts;


use Psr\Http\Message\ResponseInterface;
use MeiliSearch\Exceptions\HTTPRequestException;

abstract class Endpoint
{
    /**
     * @var Http
     */
    protected $http;

    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws HTTPRequestException@
     */
    public function parseResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() >= 300) {
            $body = json_decode($response->getBody()->getContents(), true);
            throw new HTTPRequestException($response->getStatusCode(), $body);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}