<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Remote\V5Api as Api;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Laravel\Socialite\Facades\Socialite;

class TeamsController extends Controller
{
    public function index(Factory $factory, Api $api): View
    {
        return $factory->make('teams.index', [
            'api' => $api
        ]);
    }

    public function signup(Factory $factory): View
    {
        return $factory->make('teams.signup');
    }

    public function login(Factory $factory): View
    {
        return $factory->make('teams.login');
    }

    public function auth(Request $request, Factory $factory)
    {
        $socialiteUser = Socialite::with('graph')->stateless()->user();

        return $factory->make('teams.auth', [
            'token' => $socialiteUser->token,
            'id' => $socialiteUser->id
        ]);
    }
}
