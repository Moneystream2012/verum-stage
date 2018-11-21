<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/personal-office';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('unify.personal-office.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function sendResetResponse($response)
    {
        flash()->success(trans($response))->important();

        return redirect($this->redirectPath());
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        flash()->error(trans($response));

        return redirect()->back();
    }
}
