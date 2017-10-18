<?php

namespace App\Remote;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Config\Repository;
use SoapBox\SignedRequests\Configurations\CustomConfiguration;
use SoapBox\SignedRequests\Middlewares\Guzzle\GenerateSignature;

class Client
{
    private $signedClient;

    public function __construct(Repository $config)
    {
        $this->signedClient = new GuzzleClient(['base_uri' => 'http://api.team.dev']);
        $this->signedClient->getConfig('handler')->push($this->generateSignature(), 'signed_requests');
    }

    public function newRequest(string $path): Request
    {
        return new Request(new GuzzleClient(['base_uri' => 'http://api.team.dev']));
    }

    public function newSignedRequest(string $path): Request
    {
        return new Request($this->signedClient, $path);
    }

    protected function generateSignature(): GenerateSignature
    {
        $algorithmHeader = 'GoodTalk-Algorithm';
        $signatureHeader = 'GoodTalk-Signature';
        $signingAlgorithm = 'sha256';
        $signingKey = 'secret';

        $config = new CustomConfiguration($algorithmHeader, $signatureHeader, $signingAlgorithm, $signingKey);

        return new GenerateSignature($config);
    }
}
