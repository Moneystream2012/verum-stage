<?php

namespace App\Http\Controllers\User;

use App\Amount;
use App\Jobs\User\Histories;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class BalanceController extends Controller
{
    public function withdraw_show()
    {
        $data = auth()->user()->withdraws()->orderBy('id', 'desc')->get();

        return view('unify.personal-office.finance.withdraw')->with([
            'data' => $data,
            'min' => config('mlm.withdraws.min'),
            'coefficient' => [
                'usd' => config('mlm.withdraws.usd.coefficient') * 100,
            ]]);
    }

    public function transfer_show()
    {
        $data = auth()->user()->transfers()->orWhere('to_id', auth()->id())->orderBy('id', 'desc')->get();

        return view('unify.personal-office.finance.transfer')->with([
            'data' => $data,
            'coefficient' => config('mlm.transfers.coefficient') * 100
        ]);
    }

    public function exchange_show()
    {
        $data = user()->exchanges()->orderBy('id', 'desc')->get();

        return view('unify.personal-office.finance.exchange')->with([
            'data' => $data,
            'enable_cold_balance' => user()->hasSetting('cold_balance'),
        ]);
    }

    public function exchange(Request $request)
    {
        list($from_method, $to_method) = explode(':',$request->input('exchange'));

        /*if ($from_method == 'cold_balance' && !user()->hasSetting('cold_balance')){
            return redirect()->back();
        }*/

        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01|deficiency:'.$from_method,
            'exchange' => 'required|in:balance:mining_balance',
        ]);

        $request->session()->regenerateToken();
        $amount = round($request->input('amount'), 2);

        user()->payBalance($from_method, $amount);
        user()->investBalance($to_method, $amount);

        $exchange = user()->exchanges()->create([
            'from_method' => $from_method,
            'to_method'   => $to_method,
            'amount'      => $amount,
        ]);

        dispatch(new Histories(user()->id, 'exchange', 'transfers', [
            'id'     => $exchange->id,
            'method' => $from_method,
            'to'     => $to_method,
            'amount' => formatUSD($amount),
        ]));

        flash()->success($this->trans_view('msg.success'))->important();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function withdraw(Request $request)
    {
        if (!user()->verified) return redirect()->back();

        $this->validate($request, [
            'amount'               => 'required|numeric',
            'wallet_address'       => 'required|min:8|max:160|string',
            'type_withdraw'        => 'required|string|in:balance-BTC,balance-VMC,balance-RUB,mining_balance-VMC,mining_balance-BTC,mining_balance-RUB',
            'transaction_password' => 'required|check_password',
        ]);

        list($type_balance, $currency) = explode('-',$request->input('type_withdraw'));
        $amount_to = round($request->input('amount'), 2);
        $cost_amount = round($amount_to * config('mlm.withdraws.usd.coefficient'), 2);
        $amount_from = round($cost_amount + $amount_to, 2);
        $wallet_address = $request->input('wallet_address');

        Validator::make(['amount' => $amount_from], [
            'amount' => 'numeric|deficiency:'
                .$type_balance.'|min_amount:USD,'.config('mlm.withdraws.min'),
        ])->validate();

        $request->session()->regenerateToken();

        user()->payBalance($type_balance, $amount_from);

        user()->withdraws()->create([
            'from_method'    => $type_balance,
            'to_method'      => $currency,
            'amount'         => $amount_to,
            'cost_amount'    => $cost_amount,
            'wallet_address' => $wallet_address,
        ]);

        dispatch(new Histories(user()->id, 'withdraw-processing', 'requests', [
            'method'         => $type_balance,
            'to'             => $currency,
            'amount'         => formatUSD($amount_to),
            'wallet_address' => $wallet_address,
        ]));

        flash()->success(trans('unify/personal-office/finance/withdraw.success_msg'))->important();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transfer(Request $request)
    {
        $this->validate($request, [
            'user'                 => 'required|integer|is_user',
            'amount'               => 'required|numeric|min:0.01',
            'transaction_password' => 'required|check_password',
            'type_balance'         => 'required|in:balance,mining_balance',
        ]);

        $amount_to = round($request->input('amount'), 2);
        $coefficient = config('mlm.transfers.coefficient');
        $cost_amount = round($amount_to * $coefficient, 2);
        $amount_from = round($cost_amount + $amount_to, 2);
        $type_balance =  $request->input('type_balance');

        Validator::make(['amount' => $amount_from], [
            'amount' => 'deficiency:'.$type_balance,
        ])->validate();

        $request->session()->regenerateToken();

        $from = auth()->user();
        $to = User::nameOrId($request->input('user'))->first();

        if ($from->id == $to->id) {
            return redirect()->back();
        }

        $from->payBalance($type_balance, $amount_from);
        $to->investBalance($type_balance, $amount_to);

        $from->transfers()->create([
            'from_username' => $from->username,
            'to_id'         => $to->id,
            'to_username'   => $to->username,
            'amount'        => $amount_to,
            'cost_amount'   => $cost_amount,
            'method'        => $type_balance,
        ]);

        // transfer from
        dispatch(new Histories($from->id, 'user_from-amount', 'transfers', [
            'id'          => $to->id,
            'username'    => $to->username,
            'amount'      => formatUSD($amount_to),
            'cost_amount' => formatUSD($cost_amount),
            'method'      => $type_balance,
        ]));

        // transfer to
        dispatch(new Histories($to->id, 'user_to-amount', 'transfers', [
            'id'       => $from->id,
            'username' => $from->username,
            'amount'   => formatUSD($amount_to),
            'method'   => $type_balance,
        ]));

        flash()->success(trans('unify/personal-office/finance/transfer.flash.success'))->important();

        return redirect()->back();
    }
}
