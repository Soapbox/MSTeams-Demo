<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'soapbox_id',
        'soapbox_user_id',
        'microsoft_user_id',
        'email',
        'name',
        'token'
    ];

    public function getToken(): string
    {
        return $this->token;
    }

    public static function findByMicrosoftId(string $microsoftUserId): User
    {
        return User::where('microsoft_user_id', $microsoftUserId)->firstOrFail();
    }
}
