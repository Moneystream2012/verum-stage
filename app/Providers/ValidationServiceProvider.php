<?php

namespace App\Providers;

use App\Amount;
use App\User;
use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Validator::extend('is_user', function ($attribute, $user, $parameters) {
            return User::nameOrId($user)->exists();
        });

        Validator::extend('deficiency', function ($attribute, $amount, $parameters) {
            if ($parameters[0] == 'cold_balance') {
                return Amount::whereType($parameters[0].'_'. ($parameters[1] ?? auth()->id()))->where('amount', '>=', $amount)->exists();
            }elseif ($parameters[0] == 'mining_balance'){
                $amount = USDtoVMC($amount);
            }
            return User::whereId($parameters[1] ?? auth()->id())->where($parameters[0], '>=', $amount)->exists();
        });

        Validator::extend('username', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/u', $value);
        });

        Validator::extend('check_password', function ($attribute, $value) {
            return \Hash::check($value, auth()->user()->getAttribute($attribute));
        });

        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s\']+$/u', $value);
        });

        Validator::extend('min_amount', function ($attribute, float $value, $parameters) {
            return $value >= (float) $parameters[1];
        });

        Validator::replacer('min_amount', function($message, $attribute, $rule, $parameters) {
            return str_replace(':min_amount', formatCurrency($parameters[0], $parameters[1],true), $message);
        });

        Validator::extend('max_amount', function ($attribute, float $value, $parameters) {
            return $value <= (float) $parameters[1];
        });

        Validator::replacer('max_amount', function($message, $attribute, $rule, $parameters) {
            return str_replace(':max_amount', formatCurrency($parameters[0], $parameters[1],true), $message);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
