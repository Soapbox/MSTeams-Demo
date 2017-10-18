<?php

namespace App\Remote;

use GuzzleHttp\Client;
use App\Remote\Response;
use Illuminate\Support\Collection;

class Request
{
    protected $client;
    protected $options;
    protected $uri;
    protected $version = '.v1';

    public function __construct(Client $client, string $uri)
    {
        $this->client = $client;
        $this->uri = $uri;
        $this->options = new Collection();
    }

    public function setHeader(string $key, string $value): Request
    {
        if (!$this->options->has('headers')) {
            $this->options->put('headers', new Collection());
        }

        $this->options->get('headers')->put($key, $value);
        return $this;
    }

    public function setJson($json): Request
    {
        $this->options->put('json', $json);
        return $this;
    }

    public function setJWT(string $jwt): Request
    {
        return $this->setHeader('Authorization', sprintf('Bearer %s', $jwt));
    }

    public function post(): Response
    {
        $this->setHeader('Content-Type', 'application/json');
        return $this->sendRequest($this->client, 'POST', $this->uri, $this->options->toArray());
    }

    protected function sendRequest(Client $client, string $type, string $uri, array $options): Response
    {
        return new Response($client->request($type, $uri, $options));
    }
}
