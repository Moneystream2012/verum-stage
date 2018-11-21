<?php

namespace App\Services;

use App\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function loginOrGetUser(ProviderUser $providerUser, $providerName)
    {
        $account = SocialAccount::whereProvider($providerName)->whereProviderUserId($providerUser->getId())->first();

        return $account->user ?? false;
    }

    public function addAccount(ProviderUser $providerUser, $providerName)
    {
        if (SocialAccount::whereProvider($providerName)->whereProviderUserId($providerUser->getId())->exists()) {
            flash()->error(trans('personal-office/profile.msg.social_account.busy', ['provider' => $providerName]));

            return;
        }
        $social_account = auth()->user()->social_account();

        if ($social_account->whereProvider($providerName)->exists()) {
            return;
        }

        $social_account->create([
            'provider_user_id' => $providerUser->getId(),
            'provider'         => $providerName,
        ]);

        flash()->success(trans('personal-office/profile.msg.social_account.successfully', ['provider' => $providerName]));
    }
}
