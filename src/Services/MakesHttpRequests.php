<?php

namespace Robbens\UpsalesTile\Services;

use GuzzleHttp\Psr7\Request;

trait MakesHttpRequests
{
    /**
     * Make a GET request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $params
     * @return mixed
     */
    public function get($uri, array $params = [])
    {
        return $this->request('GET', $uri, $params, []);
    }

    /**
     * Make a POST request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $params
     * @param array $payload
     * @return mixed
     */
    public function post($uri, array $params = [], array $payload = [])
    {
        return $this->request('POST', $uri, $params, $payload);
    }

    /**
     * Make a PUT request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $params
     * @param array $payload
     * @return mixed
     */
    public function put($uri, array $params = [], array $payload = [])
    {
        return $this->request('PUT', $uri, $params, $payload);
    }

    /**
     * Make a DELETE request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $params
     * @param array $payload
     * @return mixed
     */
    public function delete($uri, array $params = [], array $payload = [])
    {
        return $this->request('DELETE', $uri, $params, $payload);
    }

    /**
     * Make request to Forge servers and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array $params
     * @param array $payload
     * @return mixed
     */
    private function request($verb, $uri, array $params = [], array $payload = [])
    {
        $response = $this->guzzle->request($verb, $uri, [
            'form_params' => $payload,
            'query' => array_merge($this->guzzle->getConfig('query'), $params),
        ]);

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @param  int $timeout
     * @param  callable $callback
     * @param  int $sleep
     * @return mixed
     */
    public function retry($timeout, $callback, $sleep = 5)
    {
        $start = time();

        beginning:

        if ($output = $callback()) {
            return $output;
        }

        if (time() - $start < $timeout) {
            sleep($sleep);

            goto beginning;
        }

        throw new \Exception($output);
    }
}
