<?php

namespace App\Http\Controllers\User;

use App\Services\SocialAccountService;
use App\Http\Controllers\Controller;
use Socialite;

class SocialController extends Controller
{
    public function login($provider = null)
    {
        if (! config("services.$provider")) {
            abort('404');
        }
        \Config::set("services.$provider.redirect", route('personal-office.login.social.callback', $provider));

        return Socialite::with($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider = null)
    {
        if (! config("services.$provider")) {
            abort('404');
        }
        \Config::set("services.$provider.redirect", route('personal-office.login.social.callback', $provider));
        if (auth()->check()) {
            $service->addAccount(Socialite::driver($provider)->user(), $provider);

            return redirect()->route('personal-office.profile');
        }
        $user = $service->loginOrGetUser(Socialite::driver($provider)->user(), $provider);

        if (! $user) {
            flash()->info(trans('auth.failed-social', ['provider' => $provider]));

            return redirect()->route('personal-office.login');
        }

        flash()->success('Аутентификация через '.$provider);
        auth()->login($user);

        return redirect()->route('personal-office.dashboard');
    }
}
