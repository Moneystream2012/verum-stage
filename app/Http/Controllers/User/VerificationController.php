<?php

namespace App\Http\Controllers\User;

use App\Verification;
use Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $countries = Countries::getList(\App::getLocale());
        $verification = Verification::firstOrNew(['user_id' => auth()->id()]);

        return view('unify.personal-office.verification', [
            'countries' => $countries,
            'verification' => $verification,
        ]);
    }

    public function update(Request $request)
    {
        $mobile_number = ($request->input('mobile_number') != '' && user()->mobile_number != $request->input('mobile_number')) ? '|unique:users|unique:verifications' : '';
        $email = ($request->input('email') != '' && user()->email != $request->input('email')) ? '|unique:users|unique:verifications' : '';
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255' . $email,
            'mobile_number' => 'required|phone:mobile_code' . $mobile_number,
            'country' => 'required|string|max:2',
            'avatar' => 'required|mimes:jpeg,jpg,png|max:5120',
            'doc_img' => 'required|mimes:jpeg,jpg,png|max:5120',
            'password' => 'required|check_password',
        ]);

        if ($verification = user()->verification){
            $verification->delete();
        }

        $verification = user()->verification()->create(
            $request->except(['_token', 'avatar', 'doc_img', 'password'])
            +[
                'avatar' => str_random(16) . '.png',
                'doc_img' => str_random(16) . '.jpg'
            ]
        );

        $image = Image::make($request->file('avatar'))->fit(128)->encode('png');
        Storage::disk('verifications')->put($verification->avatar, $image->getEncoded());

        $image = Image::make($request->file('doc_img'))->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        Storage::disk('verifications')->put($verification->doc_img, $image->getEncoded());

        flash()->success(trans('unify/personal-office/verification.msg.update'))->important();

        return redirect()->back();
    }
}
