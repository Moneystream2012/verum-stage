<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Users\VerifiedEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
use Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $countries = \Countries::getList(\App::getLocale());

        return view('unify.personal-office.profile', [
            'countries'      => $countries,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $mobile_number = ($request->input('mobile_number') != '' && $user->mobile_number != $request->input('mobile_number')) ? '|unique:users' : '';
        //$email = ($request->input('email') != '' && $user->email != $request->input('email')) ? '|unique:users' : '';
        $this->validate($request, [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            //'email'         => 'required|email|max:255'.$email,
            'mobile_number' => 'required|phone:mobile_code'.$mobile_number,
            'country'       => 'required|string|max:2',
            'avatar'        => 'mimes:jpeg,jpg,png|max:1024',
            'password'      => 'required|check_password',
        ]);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile_number = $request->input('mobile_number');
        $user->country = $request->input('country');

        /*if (false && $user->email != $request->input('email')) {
            $user->email = $request->input('email');
            $user->verified_email = false;
            $user->token_email = str_random(30);

            \Mail::to($user)->send(new VerifiedEmail(route('personal-office.verify_email', $user->token_email)));

            flash()->success(trans('personal-office/profile.msg.email.activation', ['email' => $user->email]))->important();
        }*/
        if ($request->hasFile('avatar')) {
            $image = Image::make($request->file('avatar'))->fit(128)->encode('png');
            $filename = str_random().'.png';
            $avatars = Storage::disk('avatars');
            if ($avatars->put($filename, $image->getEncoded())) {
                if (isset($user->avatar) && $avatars->has($user->avatar)) {
                    $avatars->delete($user->avatar);
                }
                $user->avatar = $filename;
            }
        }
        if($user->verified){
            $user->verification->delete();
        }

        $user->updated_at = Carbon::now();
        $user->save();

        flash()->success(trans('unify/personal-office/profile.msg.update'))->important();

        return redirect()->back();
    }

    public function remove_social_account($provider)
    {
        if (in_array($provider, [
                'vkontakte',
                'facebook',
                'twitter',
                'instagram',
            ]) && auth()->user()->social_account()->whereProvider($provider)->delete()
        ) {
            flash()->success(trans('personal-office/profile.msg.social_account.cancelled', ['provider' => $provider]));
        }

        return redirect()->back();
    }

    public function active_member()
    {
        return view('personal-office.active_member');
    }

    public function send_activation()
    {
        $user = auth()->user();
        if (! $user->verified_email) {
            if (cache()->has($user->id.':send_activation_email')) {
                flash()->error(trans('personal-office/profile.msg.email.resending'))->important();

                return redirect()->back();
            }
            cache()->put($user->id.':send_activation_email', true, 5);

            \Mail::to($user)->send(new VerifiedEmail(route('personal-office.verify_email', $user->token_email)));
            flash()->success(trans('personal-office/profile.msg.email.activation', ['email' => $user->email]))->important();
        } else {
            flash()->success(trans('personal-office/profile.msg.email.confirmed'))->important();
        }

        return redirect()->back();
    }

    public function showBlocked()
    {
        return view('unify.personal-office.blocked');
    }
}
