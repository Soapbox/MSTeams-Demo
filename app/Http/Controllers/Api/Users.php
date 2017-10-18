<?php

namespace App\Http\Controllers\Api;

// use App\Users\User;
// use App\Channels\Channel;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
// use GuzzleHttp\Exception\ClientException;
// use App\Users\Remote\Service as UserService;
// use App\Channels\Remote\Service as ChannelService;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class Users extends Controller
{
    public function invite(Request $request)
    {
        \Log::info('Users::invite()');
        \Log::info($request->all());

        // $channel = Channel::findByMicrosoftId($request->input('channel.id'));

        // $actor = User::findOrCreate(
        //     $request->input('actor.id'),
        //     $channel->soapbox,
        //     $request->input('actor.name'),
        //     $request->input('actor.email')
        // );

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
