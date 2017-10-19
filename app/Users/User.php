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

    public function getSoapboxId(): int
    {
        return $this->soapbox_id;
    }

    public function getSoapboxUserId(): int
    {
        return $this->soapbox_user_id;
    }

    public static function findByMicrosoftId(string $microsoftUserId): User
    {
        return User::where('microsoft_user_id', $microsoftUserId)->firstOrFail();
    }

    public function setToken(string $token): User
    {
        $this->token = $token;

        return $this;
    }
}
