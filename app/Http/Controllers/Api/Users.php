<?php

namespace App\Http\Controllers\Api;

use App\Users\User;
use App\Channels\Channel;
use App\Remote\V5Api as Api;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Users extends Controller
{
    public function invite(Request $request, Api $api)
    {
        \Log::info('Users::invite()');
        \Log::info($request->all());

        $channelId = $request->input('channel.id');

        try {
            $channel = Channel::findByMicrosoftId($channelId);
        } catch (ModelNotFoundException $e) {
            return new Response('Channel not found', 404);
        }

        $inviterId = $request->input('actor.id');
        try {
            $inviter = User::findByMicrosoftId($inviterId);
        } catch (ModelNotFoundException $e) {
            return new Response('User not found', 404);
        }


        $userId = $request->input('user.id');
        $name = $request->input('user.name');
        $email = $request->input('user.email');
        try {
            $user = User::findByMicrosoftId($userId);
        } catch (ModelNotFoundException $e) {
            $data = [
                'email' => $email,
                'name' => $name,
                'slack' => $userId
            ];
            $response = $api->createUser($channel, $data);
            $data = $response->getDecodedContents();
            $remoteUser = $data['data'];

            $user = new User([
                'soapbox_id' => $remoteUser['attributes']['soapbox-id'],
                'soapbox_user_id' => $remoteUser['id'],
                'microsoft_user_id' => $userId,
                'email' => $remoteUser['attributes']['email'],
                'name' => $remoteUser['attributes']['name'],
                'token' => 'TEST'
            ]);
            $user->save();
        }

        $api->inviteToChannel($channel, $inviter, $user, 'employee');

        return new Response();
        // $userId = $request->input('user.id');
        // $userName = $request->input('user.name');
        // $userEmail = $request->input('user.email');

        // $user = User::findOrCreate($userId, $channel->soapbox, $userName, $userEmail);

        // if (!$user->isSynced()) {
        //     $response = (new UserService())->invite($actor, $user);
        //     $user->updateGoodTalkId($response->getDecodedContents()['data']['id']);
        // }

        // try {
        //     (new ChannelService())->addUser($channel, $actor, $user, $request->input('user.role'));
        // } catch (ClientException $exception) {
        //     if ($exception->getCode() != Response::HTTP_UNPROCESSABLE_ENTITY) {
        //         throw $exception;
        //     }
        // }
    }
}
