<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return abort(404);
        return view('personal-office.settings');
    }

    public function payment(Request $request)
    {
        $this->validate($request, [
            'perfectmoney' => 'regex:/^U\d{5,8}$/',
            'advcash'      => 'regex:/^U[0-9\s]+$/',
        ]);
        $user = auth()->user();

        if ($request->has('perfectmoney') && ! $user->hasSetting('perfectmoney')) {
            $user->setSetting($request->only('perfectmoney'));
            flash()->success(trans('personal-office/settings.success.payment'))->important();
        }

        if ($request->has('advcash') && ! $user->hasSetting('advcash')) {
            $user->setSetting($request->only('advcash'));
            flash()->success(trans('personal-office/settings.success.payment'))->important();
        }

        return redirect()->back();
    }

    public function password(Request $request)
    {
        $this->validate($request, [
            'password'                 => 'required_with:new_password|check_password',
            'new_password'             => 'confirmed|min:6|max:255',
            'transaction_password'     => 'required_with:new_transaction_password|check_password',
            'new_transaction_password' => 'confirmed|max:255',
        ]);
        $user = auth()->user();

        if ($request->has('new_password')) {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            flash()->success(trans('personal-office/settings.success.password'))->important();
        }

        return redirect()->back();
    }

    public function transaction_password(Request $request)
    {
        $this->validate($request, [
            'transaction_password'     => 'required_with:new_transaction_password|check_password',
            'new_transaction_password' => 'confirmed|max:255',
        ]);
        $user = auth()->user();

        if ($request->has('new_transaction_password')) {
            $user->transaction_password = bcrypt($request->input('new_transaction_password'));
            $user->save();
            flash()->success(trans('personal-office/settings.success.transaction_password'))->important();
        }

        return redirect()->back();
    }

    public function binary_side()
    {
        $user = auth()->user();
        if (! $user->team_developer) {
            return redirect()->back();
        }
        $user->side_leg = ! $user->side_leg;
        $user->save();
        flash()->success('Binary side: '.(! $user->side_leg ? 'left' : 'right'))->important();

        return redirect()->back();
    }
}
