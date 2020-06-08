<?php

namespace Robbens\UpsalesTile\Services;

use GuzzleHttp\Client;
use Robbens\UpsalesTile\Services\Actions\Orders;

/**
 * @TODO When this API wrapper has more endpoints/actions, it should be extracted to its own package.
 */
class UpsalesApi
{
    const API_BASE_URL = 'https://integration.upsales.com/api/v2/';

    use MakesHttpRequests,
        Orders;

    /**
     * The Upsales API Key.
     */
    public string $token;

    /**
     * The Guzzle HTTP Client instance.
     */
    public Client $guzzle;

    /**
     * Number of seconds a request is retried.
     */
    public int $timeout = 30;

    /**
     * Create a new Forge instance.
     *
     * @param  string $apiToken
     * @param  Client $guzzle
     * @return void
     */
    public function __construct($apiToken = null, Client $guzzle = null)
    {
        if (! is_null($apiToken)) {
            $this->setToken($apiToken, $guzzle);
        }

        if (! is_null($guzzle)) {
            $this->guzzle = $guzzle;
        }
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param  array $collection
     * @param  string $class
     * @param  array $extraData
     * @return array
     */
    protected function transformCollection($collection, $class, $extraData = [])
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection);
    }

    /**
     * Set the api key and setup the guzzle request object.
     *
     * @param string $apiKey
     * @param Client $guzzle
     * @return $this
     */
    public function setToken(string $apiKey, $guzzle)
    {
        $this->token = $apiKey;

        $this->guzzle = $guzzle ?: new Client([
            'base_uri' => self::API_BASE_URL,
            'query' => [
                'token' => $this->token,
                'limit' => 50,
            ],
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $this;
    }

    /**
     * Set a new timeout.
     *
     * @param  int $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the timeout.
     *
     * @return  int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
