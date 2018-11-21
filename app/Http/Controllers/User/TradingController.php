<?php

namespace App\Http\Controllers\User;

use App\Events\Users\InvestTrading;
use App\Trading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TradingController extends Controller
{
    public function index()
    {
        $data = user()->tradings()->orderby('id', 'DESK')->where('status','<', Trading::REFUND)->get();
        return view('unify.personal-office.trading.index', [
            'data' => $data,
            'payout_count' => Trading::PAYOUT_COUNT,
            'percent_payout' => Trading::getPercentPayout(),
            'invest' => (object) config('mlm.trading.invest'),
            'enable_cold_balance' => user()->hasSetting('cold_balance'),
        ]);
    }

    public function invest(Request $request)
    {
        $payment_method = $request->input('payment_method');

        if ($payment_method == 'cold_balance' && !user()->hasSetting('cold_balance')){
            return redirect()->back();
        }

        $this->validate($request, [
            'payment_method' => 'required|in:balance,mining_balance,cold_balance',
            'amount' => 'required|numeric|min_amount:USD,'
                . config('mlm.trading.invest.min')
                . '|max_amount:USD,' . config('mlm.trading.invest.max')
                . '|deficiency:' . $payment_method,
        ]);

        $trading = user()->tradings()->create([
            'invest' => round($request->input('amount'),2),
        ]);

        user()->payBalance($payment_method, $trading->invest);
        event(new InvestTrading(user(), $trading, [
            'method' => $payment_method,
            'currency' => 'USD',
        ]));

        flash()->success($this->trans_view('msg.success'))->important();

        return redirect()->back();
    }
}
