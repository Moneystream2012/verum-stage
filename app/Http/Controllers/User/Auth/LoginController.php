<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Changelog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/personal-office';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest:user', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('unify.personal-office.auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        flash()->success(trans('auth.signed_out'));

        return redirect()->route('personal-office.login');
    }

    protected function authenticated()
    {
        flash()->success(trans('auth.signed_in-success'))->important();
        $changelog = Changelog::where('active', true)->first();
        if ($changelog) {
            flash()->overlay(view('include.banner', ['item' => $changelog])->render(), 'News');
        }

        return redirect()->route('personal-office.dashboard');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        flash()->error(trans('auth.failed'));

        return redirect()->back()->withInput($request->only($this->username(), 'remember'));
    }

    public function username($username = null)
    {
        if ($username == null) {
            return 'username_or_uid';
        }
        if (ctype_digit($username)) {
            return 'id';
        }

        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $field = $this->username($request->input($this->username()));
        $this->validate($request, [
            $this->username() => 'required|string' . ($field == 'id' ? '|max:8' : ''),
            'password' => 'required|string',
//            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    protected function credentials(Request $request)
    {
        $username = $request->input($this->username());
        $field = $this->username($username);
        return [
            $field     => $username,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
}
