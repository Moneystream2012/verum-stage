<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        View::composer(['unify.personal-office.*'], function (\Illuminate\Contracts\View\View $view) {
            $view_src = str_replace('.', '/', $view->name());
            $v_lang = (object)trans($view_src);

            $l_lang = (object)trans('unify/layouts/personal-office');

            $view->with([
                'l_lang' => $l_lang,
                'v_lang' => $v_lang,
            ]);
        });


        View::composer(['personal-office.*'], function ($view) {
            $view_src = str_replace('.', '/', $view->getName());


            $view->with([
                'v_lang' => (object)trans($view_src),
            ]);
        });

        View::composer(['unify.personal-office.*', 'administrator.*', 'personal-office.*'], function ($view) {
            $view->with([
                'auth' => auth()->user(),
            ]);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
