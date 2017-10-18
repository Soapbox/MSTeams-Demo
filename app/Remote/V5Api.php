<?php

namespace App\Remote;

use App\Users\User;
use App\Remote\Client;

class V5Api
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function registerSoapbox(array $data)
    {
        $response = $this->client
            ->newSignedRequest('create/brain')
            ->setJson($data)
            ->post();

        return [
            'token' => $response->get('token'),
            'soapbox_id' => $response->get('soapbox_id'),
            'soapbox_user_id' => $response->get('soapbox_user_id')
        ];
    }

    public function createChannel(User $user, array $data)
    {
        $response = $this->client
            ->newSignedRequest('/channels')
            ->setJwt($user->getToken())
            ->setJson($data)
            ->post();

        return $response;
    }
}