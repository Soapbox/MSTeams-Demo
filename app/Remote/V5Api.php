<?php

namespace App\Remote;

use App\Users\User;
use App\Remote\Client;
use App\Channels\Channel;

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
            ->newRequest('/channels')
            ->setJwt($user->getToken())
            ->setJson($data)
            ->post();

        return $response;
    }

    public function generateAutoLogin(User $user)
    {
        $response = $this->client
            ->newRequest('/users/me/auto')
            ->setJwt($user->getToken())
            ->get();

        return $response;
    }

    public function createUser(Channel $channel, array $data)
    {
        $response = $this->client
            ->newSignedRequest('/soapboxes/' . $channel->getSoapboxId() . '/users')
            ->setJson($data)
            ->post();

        return $response;
    }

    public function inviteToChannel(Channel $channel, User $inviter, User $user, string $role)
    {
        $response = $this->client
            ->newRequest(sprintf('/channels/%s/users', $channel->getSoapboxChannelId()))
            ->setJwt($inviter->getToken())
            ->setJson([
                'user-id' => $user->getSoapboxId(),
                'user-type' => $role
            ])
            ->post();

        return $response;
    }
}
