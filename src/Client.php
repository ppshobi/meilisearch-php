<?php

namespace MeiliSearch;

use MeiliSearch\Contracts\Endpoint;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;

class Client
{
    /**
     * @var Http\Client
     */
    private $http;

    public function __construct($url, $apiKey = null, ClientInterface $httpClient = null, RequestFactoryInterface $requestFactory = null, StreamFactoryInterface $streamFactory = null)
    {
        $this->http = new Http\Client($url, $apiKey, $httpClient, $requestFactory, $streamFactory);
    }

    public function getAllIndexes()
    {
        return $this->http->get('/indexes');
    }

    public function showIndex($uid)
    {
        return (new Index($uid, $this->http))->show();
    }

    public function deleteIndex($uid)
    {
        return $this->indexInstance($uid)->delete();
    }

    public function deleteAllIndexes()
    {
        foreach ($this->getAllIndexes() as $index) {
            $this->deleteIndex($index['uid']);
        }
    }

    public function getIndex($uid)
    {
        return $this->indexInstance($uid);
    }

    public function createIndex($attributes): Index
    {
        return (new Index($this->http))
        ->create($attributes);
    }

    // Health

    public function health()
    {
        return $this->httpGet('/health');
    }

    // Stats

    public function version()
    {
        return $this->httpGet('/version');
    }

    public function sysInfo()
    {
        return $this->httpGet('/sys-info');
    }

    public function prettySysInfo()
    {
        return $this->httpGet('/sys-info/pretty');
    }

    public function stats()
    {
        return $this->httpGet('/stats');
    }

    // Keys

    public function getKeys()
    {
        return $this->httpGet('/keys');
    }

    // Private methods

    private function indexInstance($uid)
    {
        return new Index($uid, $this->base_url, $this->api_key);
    }
}
