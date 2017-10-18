<?php

namespace App\Http\Controllers\Api;

// use App\Channels\Channel;
// use App\SoapBoxes\SoapBox;
// use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use App\Users\Creator as UserCreator;
// use App\Users\Remote\Service as UserService;
// use App\SoapBoxes\Creator as SoapBoxCreator;
// use App\Channels\Remote\Service as ChannelService;
// use App\SoapBoxes\Remote\Service as SoapBoxService;
// use App\Authentication\Remote\Service as AuthService;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class Tab extends Controller
{
    public function configure(Request $request)
    {
        \Log::info('Tab::configure()');
        \Log::info($request->all());

        // $tenantId = $request->input('tenant_id');
        // $channelId = $request->input('channel_id');
        // $soapboxName = $request->input('soapbox_name');
        // $channelName = $request->input('channel_name');
        // $soapboxSlug = Str::slug($soapboxName);

        // $authService = new AuthService();
        // $user = Auth::user();

        // try {
        //     $soapbox = SoapBox::findByMicrosoftId($tenantId);
        // } catch (ModelNotFoundException $exception) {
        //     $soapbox = (new SoapBoxCreator())->create($tenantId, $user->name, $user->email, $soapboxName, $soapboxSlug);
        //     $user->soapbox_id = $soapbox->id;
        //     $user->save();
        // }

        // $user = (new UserCreator())->create($user->microsoft_id, $soapbox, $user->name, $user->email);

        // try {
        //     $channel = Channel::findByMicrosoftId($channelId);
        // } catch (ModelNotFoundException $exception) {
        //     $response = (new ChannelService())->create($user, $channelName);
        //     $channel = Channel::create($soapbox, $channelId, $response->getDecodedContents()['data']['id']);
        // }

        // $data = [
        //     'url' => route('tab', ['channel' => $channel->id]) . '&tenant_id={tid}'
        // ];

        // return new Response($data);
    }
}
