<?php

namespace App\Http\Controllers\User;

use App\Amount;
use App\Deposit;
use App\Events\Users\PaymentDeposit;
use App\Jobs\User\Histories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositsController extends Controller
{
    public function indexUsd()
    {
        $user = auth()->user();
        $deposits = $user->deposits()->orderby('id', 'DESK')->where('old', false)->get();

        return view('unify.personal-office.deposits.usd', [
            'data' => $deposits,
            'products' => Deposit::PRODUCTS,
            'enable_cold_balance' => user()->hasSetting('cold_balance'),
        ]);
    }

    public function payment(Request $request, Deposit $deposit)
    {
        $product = Deposit::PRODUCTS[$request->input('plan')];
        $data = [
            'method' => $request->input('method'),
            'currency' => $request->input('currency')
        ];
        if ($data['method'] == 'cold_balance' && !user()->hasSetting('cold_balance')){
            return redirect()->back();
        }

        $this->validate($request, [
            'method' => 'required|in:balance,mining_balance,cold_balance',
            'service' => 'required|in:deposit',
            'currency' => 'required|in:USD',
            'invest' => 'required|numeric|min_amount:USD,'
                . $product['min']
                . '|max_amount:USD,' . $product['max']
                . '|deficiency:' . $data['method'],
            'plan' => 'required_if:service,deposit|integer|in:1,2,3,4,5,6',
        ]);

        /*if($data['method'] == 'mining_balance') {
            flash()->error('Investment is prohibited from this balance sheet.')->important();
            return redirect()->back();
        }*/

        $user = auth()->user();
        $deposit->id = $deposit->getNextIdNumber();
        $deposit->user_id = $user->id;
        $deposit->plan = $request->input('plan');
        $deposit->invest = $request->input('invest');
        $deposit->payout_count = $product['payout_count'];

        try {
            $deposit->save();
        } catch (\Exception $e) {
            $deposit->delete();
            flash()->error('Whoops! Error Pay.')->important();

            return redirect()->back();
        }
        if ($deposit->plan > $user->plan){
            $user->update(['plan' => $deposit->plan]);
        }
        $user->payBalance($data['method'], $deposit->invest);
        event(new PaymentDeposit($user, $deposit, $data));
        $currency = strtolower($data['currency']);
        flash(trans('personal-office/products/deposits/' . $currency . '.success'), 'success')->important();

        return redirect()->route('personal-office.products.deposits.' . $currency);
    }

    public function transfer(Request $request)
    {
        return;
        $request->session()->regenerateToken();
        $this->validate($request, [
            'deposit_id' => 'required|integer',
            'amount_transfer' => 'required|numeric',
        ]);
        $deposit = Deposit::findOrFail($request->input('deposit_id'));
        $this->authorize('update', $deposit);

        $amount_transfer = round($request->input('amount_transfer'), 2);

        if ($deposit->available_amount_transfer >= $amount_transfer) {
            $deposit->withdrawal_amount += $amount_transfer;
            $deposit->profit -= $amount_transfer;
            $deposit->withdrawal_at = Carbon::now();
            $deposit->save();
            auth()->user()->investBalance('balance', $amount_transfer);
            dispatch(new Histories(auth()->id(), 'deposit', 'transfers', [
                'id' => $deposit->id,
                'to' => 'balance',
                'name' => $deposit->product['name'],
                'amount' => formatUSD($amount_transfer),
            ]));
            flash()->success(trans('personal-office/products/deposits.transfer'));
        } else {
            flash()->error(trans('validation.deficiency'));
        }

        return redirect()->back();
    }
}
