<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\SocialiteInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialite extends Controller implements SocialiteInterface
{

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password'=> Hash::make('usuarioautenticadopelogoogle'),
            'email_verified_at' => now(),
            'image' => '/images/avatar.jpg'
        ]);
                dd($user);

        Auth::login($user);

        return redirect('/app');
    }
}
