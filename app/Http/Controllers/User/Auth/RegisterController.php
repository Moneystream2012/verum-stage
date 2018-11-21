<?php

namespace App\Http\Controllers\User\Auth;

use App\Events\Users\Registered;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/personal-office';

    public function __construct()
    {
        $this->middleware('guest:user', ['except' => 'verify']);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'required|max:60|min:2|alpha',
            'last_name'     => 'required|max:60|min:2|alpha',
            'username'      => 'required|username|max:30|min:3|unique:users',
            'email'         => 'required|email|max:255|unique:users',
            //'mobile_number' => 'required|phone:mobile_code|unique:users',
            'mobile_number' => 'required|numeric|unique:users',
            'sponsor'       => 'required|alpha_dash|max:60|is_user',
            'password'      => 'required|min:6|max:255|confirmed',
            'country'       => 'required|string|max:2',
            'terms'         => 'required|accepted',
            '18_years'      => 'required|accepted',
//            'g-recaptcha-response' => 'required|captcha',
        ]);

        $data = $request->toArray();
        $sponsor = User::nameOrId($data['sponsor'])->select('id', 'side_leg', 'settings')->first();

        $data['transaction_password'] = str_random(8);
        $data['sponsor_id'] = $sponsor->id;
        $data['side_leg'] = $sponsor->side_leg;
        $data['leg'] = $sponsor->side_leg;
        $data['mobile_number'] = phone($request->input('mobile_number'), $request->input('mobile_code'), 0);

        if (! $sponsor->team_developer) {
            $sponsor->side_leg = ! $sponsor->side_leg;
            $sponsor->save();
        }

        $user = User::createUser($data);
        $data['id'] = $user->id;

        event(new Registered($user, $data));

        return view('unify.personal-office.auth.login-details')->with('user', (object) $data);
    }

    public function showRegistrationForm($sponsor = null)
    {
        $countries = \Countries::getList(\App::getLocale());

        return view('unify.personal-office.auth.register')->with([
            'sponsor'   => $sponsor,
            'countries' => $countries,
        ]);
    }

    public function verify($token)
    {
        try {
            $user = User::whereTokenEmail($token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            flash()->error('Your account could not be verified.')->important();

            return redirect(route('personal-office.login'));
        }
        $user->verified_email = true;
        $user->token_email = null;
        $user->save();

        auth()->login($user);

        flash()->success('Your account verified successfully activated.')->important();
        //if ($user->active_year) {
        return redirect()->route('personal-office.dashboard');
        //}

        //return redirect()->route('personal-office.active_member');
    }
}
