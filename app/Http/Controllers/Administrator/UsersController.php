<?php

namespace App\Http\Controllers\Administrator;

use App\Binary;
use App\DataTables\Administrator\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Notifications\Users\NewNoticeMessage;
use App\User;
use App\Withdraw;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('administrator.users.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $countries = \Countries::getList(\App::getLocale());
//        $binary_points = Binary::getPointsByUserId($user->id);
//        $matching_bonus = $premium_rank = 0;

//        if ($user->team_developer) {
//            $matching_bonus = $user->computes()->matching()->remember(60)->sum('amount') ?? 0;
//        }

//        if ($user->rank > 1) {
//            $premium_rank = $user->premium_rank()->sum('amount') ?? 0;
//        }

//        $overall_bonus = ($user->turnover2s->direct_total ?? 0) + $matching_bonus + $user->binary_total + $premium_rank;

        $withdraws = $user->withdraws;
        $withdraw_processing = $withdraws->where('status', Withdraw::STATUS_PROCESSING)->groupBy('to_method')->map(function (
            $item
        ) {
            return $item->sum('amount');
        });
        $withdraw_success = $withdraws->where('status', Withdraw::STATUS_SUCCESS)->groupBy('to_method')->map(function (
            $item
        ) {
            return $item->sum('amount');
        });
        $withdraw_rejection = $withdraws->where('status', Withdraw::STATUS_REJECTION)->groupBy('to_method')->map(function (
            $item
        ) {
            return $item->sum('amount');
        });

        return view('administrator.users.profile', [
            'user'           => $user,
            'countries'      => $countries,
            'binary_points'  => 0,
            'turnover'       => $user->turnover2s,
            'withdraws_amount'      => [
                'processing' => $withdraw_processing,
                'success'    => $withdraw_success,
                'rejection'  => $withdraw_rejection,
            ],
            'overall_bonus'  => 0,
            'matching_bonus' => 0,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $mobile_number = ($request->input('mobile_number') != '' && $user->mobile_number != $request->input('mobile_number')) ? '|unique:users' : '';
        $email = ($request->input('email') != '' && $user->email != $request->input('email')) ? '|unique:users' : '';

        $this->validate($request, [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'required|email|max:255'.$email,
            'mobile_number' => 'required|phone:mobile_code'.$mobile_number,
        ]);

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->has('transaction_password')) {
            $user->transaction_password = bcrypt($request->input('transaction_password'));
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        if ($user->email != $request->input('email')) {
            $user->email = $request->input('email');
            $user->verified_email = false;
            $user->token_email = str_random(30);
        }
        $user->mobile_number = $request->input('mobile_number');

        $user->old = $request->input('allow_withdraw');

        $user->save();

        if ($request->input('blocked') == 1 && ! $user->blocked) {
            $user->setSetting(['blocked' => true]);
        }elseif ($request->input('blocked') == 0 && $user->blocked) {
            $user->forgetSetting('blocked');
        }
        //TEAM DEVELOPER
        if ($request->input('team_developer') == 1 && ! $user->team_developer) {
            $user->rank = 1;
            $user->setSetting(['team_developer' => true]);
        } elseif ($request->input('team_developer') == 0 && $user->team_developer) {
            $user->forgetSetting('team_developer');
        }

        //COLD BALANCE
        if ($request->input('cold_balance') == 1 && ! $user->hasSetting('cold_balance')) {
            $user->setSetting(['cold_balance' => true]);
        } elseif ($request->input('cold_balance') == 0 && $user->hasSetting('cold_balance')) {
            $user->forgetSetting('cold_balance');
        }

        flash()->success(trans('personal-office/profile.msg.update'))->important();

        return redirect()->back();
    }

    public function send_notice(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:250',
        ]);
        $user = User::findOrFail($request->input('user_id'));
        $user->notify(new NewNoticeMessage($request->input('body')));
        flash()->success('Уведомление отправлено!');

        return redirect()->back();
    }
}
