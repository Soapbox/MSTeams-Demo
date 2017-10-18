<?php

namespace App\Channels;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'soapbox_channel_id',
        'microsoft_channel_id'
    ];

    public static function findByMicrosoftId(string $microsoftChannelId): Channel
    {
        return Channel::where('microsoft_channel_id', $microsoftChannelId)->firstOrFail();
    }
}
