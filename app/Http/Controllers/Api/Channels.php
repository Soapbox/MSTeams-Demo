<?php

namespace App\Http\Controllers\Api;

use App\Users\User;
use App\Channels\Channel;
use App\Soapboxes\Soapbox;
use Illuminate\Support\Str;
use App\Remote\V5Api as Api;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Channels extends Controller
{
    public function get(Request $request)
    {
        \Log::info($request->all());

        $channel = Channel::findByMicrosoftId($request->input('id'));

        return new Response([
            'channel' => $channel->toArray()
        ]);
    }

    public function store(Request $request, Api $api)
    {
        $tenantId = $request->input('tenant.id');
        $soapboxName = 'obitest';
        $soapboxSlug = 'obitest';
        $userId = $request->input('actor.id');
        $userName = $request->input('actor.name');
        $userEmail = $request->input('actor.email');

        try {
            $soapbox = Soapbox::findByTenantId($tenantId);
        } catch (ModelNotFoundException $e) {
            $data = [
                'soapbox-name' => $soapboxName,
                'soapbox-slug' => $soapboxSlug,
                'slack-team-id' => $tenantId,
                'slack-user-id' => $userId,
                'user-name' => $userName,
                'user-email' => $userEmail
            ];

            $res = $api->registerSoapbox($data);

            $soapbox = new Soapbox([
                'soapbox_id' => $res['soapbox_id'],
                'tenant_id' => $tenantId,
                'slug' => $soapboxSlug
            ]);
            $soapbox->save();
        }

        try {
            $user = User::findByMicrosoftId($userId);
        } catch (ModelNotFoundException $e) {
            $user = new User([
                'soapbox_id' => $soapbox->getSoapboxId(),
                'soapbox_user_id' => $res['soapbox_user_id'],
                'microsoft_user_id' => $userId,
                'email' => $userEmail,
                'name' => $userName,
                'token' => $res['token']
            ]);
            $user->save();
        }

        $channelId = $request->input('channel.id');
        $channelName = $request->input('channel.name');

        try {
            $channel = Channel::findByMicrosoftId($channelId);
        } catch (ModelNotFoundException $e) {
            $data = [
                'name' => $channelName,
                'user-type' => 'manager',
                'channel-type' => 'group'
            ];

            $res = $api->createChannel($user, $data);
            $remoteChannel = $res->getDecodedContents();

            $channel = new Channel([
                'soapbox_id' => $soapbox->getSoapboxId(),
                'soapbox_channel_id' => $remoteChannel['data']['id'],
                'microsoft_channel_id' => $channelId
            ]);
            $channel->save();
        }

        return new Response();
    }
}
