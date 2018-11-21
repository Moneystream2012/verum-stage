<?php

namespace App\Http\Middleware;

use App;
use Auth;
use Carbon\Carbon;
use Closure;
use Config;

class Locale
{
    private $languages;
    private $locale;

    public function __construct(Config $config)
    {
        $this->languages = $config::get('app.locales');
        $this->locale = $config::get('app.locale');
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->get('lang');

        if (in_array($lang, $this->languages)) {
            $this->locale = $lang;
            if (Auth::check()) {
                $request->user()->setSetting(['lang' => $this->locale]);
            }
            $request->session()->put('lang', $this->locale);
            return redirect()->back();
        }

        if ($request->session()->has('lang')) {
            $this->locale = $request->session()->get('lang');
        } elseif (Auth::check() && $request->user()->hasSetting('lang')) {
            $this->locale = $request->user()->getSetting('lang');
            $request->session()->put('lang', $this->locale);
        } else {
            $lang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if (in_array($lang, $this->languages)) {
                $this->locale = $lang;
            }
        }

        App::setLocale($this->locale);
        Carbon::setLocale($this->locale);
        setlocale(LC_TIME, $this->locale .'_'.strtoupper($this->locale).'.utf-8');

        return $next($request);
    }
}
