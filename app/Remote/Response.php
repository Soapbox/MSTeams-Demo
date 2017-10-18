<?php

namespace App\Remote;

use Exception;
use Illuminate\Support\Collection;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use SoapBox\Exceptions\Internal\ParseException;

class Response
{
    private $response;
    private $decodedBody;

    /**
     * Construct a new response object from the given guzzle response
     *
     * @param \GuzzleHttp\Response $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the decoded body of this response
     *
     * @throws \SoapBox\Exceptions\Internal\ParseException
     *         Thrown when unable to read or an error occurs while reading.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDecodedContents(): Collection
    {
        if (is_null($this->decodedBody)) {
            $this->decodedBody = json_decode($this->getContents(), true);
        }

        return new Collection($this->decodedBody);
    }

    /**
     * Get the body value for the given key
     *
     * @throws \SoapBox\Exceptions\Internal\ParseException
     *         Thrown when unable to read or an error occurs while reading.
     *
     * @param string $key
     *        The key in the body to select the value for
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->getDecodedContents()->get($key);
    }

    /**
     * Get whether or not this response contains a body value with the given key
     *
     * @throws \SoapBox\Exceptions\Internal\ParseException
     *         Thrown when unable to read or an error occurs while reading.
     *
     * @param string $key
     *        The key in the body to search for
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->getDecodedContents()->has($key);
    }

    /**
     * Get the raw body contents for this response
     *
     * @throws \SoapBox\Exceptions\Internal\ParseException
     *         Thrown when unable to read or an error occurs while reading.
     *
     * @return string
     */
    public function getContents(): string
    {
        try {
            return $this->getBody()->getContents();
        } catch (Exception $exception) {
            throw new ParseException('There was a problem parsing the response', 0, $exception);
        }
    }

    /**
     * Get the Guzzle Response that this Response decorates
     *
     * @return \GuzzleHttp\Response
     *         The decorated response
     */
    public function getGuzzleResponse(): GuzzleResponse
    {
        return $this->response;
    }

    /**
     * Delegate method calls to the guzzle response methods
     *
     * @param string $name
     *        The method name to call
     * @param array $arguments
     *        The array of arguments supplied to the given method
     *
     * @return mixed
     *         The return value from the delegated method call
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array([$this->response, $name], $arguments);
    }
}
