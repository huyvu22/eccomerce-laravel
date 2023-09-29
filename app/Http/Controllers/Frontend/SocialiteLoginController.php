<?php

namespace App\Http\Controllers\Frontend;

use App\Models\SocialiteLogin;
use App\Models\User;

use Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends \App\Http\Controllers\Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $socialiteUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            [
                'email' => $socialiteUser->getEmail(),
            ],
            [
                'name' => $socialiteUser->getName(),
                'password' => \Hash::make(Str::random(8))
            ]
        );

        SocialiteLogin::firstOrCreate(
            [
                'user_id' => $user->id,
                'provider' => 'google',
            ],
            [
                'provider_id' => $socialiteUser->getId()
            ]
        );

        Auth::login($user, true);
        return redirect('/');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $socialiteUser = Socialite::driver('facebook')->user();

        $user = User::firstOrCreate(
            [
                'email' => $socialiteUser->getEmail(),
            ],
            [
                'name' => $socialiteUser->getName(),
                'password' => \Hash::make(Str::random(8))
            ]
        );

        SocialiteLogin::firstOrCreate(
            [
                'user_id' => $user->id,
                'provider' => 'facebook',
            ],
            [
                'provider_id' => $socialiteUser->getId()
            ]
        );

        Auth::login($user, true);
        return redirect('/');
    }

    public function privacyPolicy()
    {
        return 'Privacy Policy';
    }
}
