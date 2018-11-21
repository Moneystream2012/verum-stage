<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('unify.personal-office.auth.passwords.email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkResponse($response)
    {
        flash()->success(trans($response));

        return redirect()->back();
    }
}
