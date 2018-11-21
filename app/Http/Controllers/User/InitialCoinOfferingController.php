<?php

namespace App\Http\Controllers\User;

use App\Amount;
use App\Http\Controllers\Controller;
use App\InitialCoinOffering;
use App\Jobs\User\BinaryPointCalculate;
use App\Jobs\User\Histories;
use App\Jobs\User\Turnovers;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Validator;

class InitialCoinOfferingController extends Controller
{
    public function showTelegram()
    {
        $data = auth()->user()->initial_coin_offerings()->where('ico_type', 'telegram')->latest()->get();
        $amount_invest = $data->sum('amount');
        $all_invest = InitialCoinOffering::sum('amount') + Amount::typeGetAmount('ico_telegram_fake');

        $chart = Charts::create('pie', 'highcharts')
            ->title(' ')
            ->labels(['Investments', 'Your'])
            ->values([$all_invest, $amount_invest])
            ->responsive(true);

        return view('personal-office.ico.telegram')->with([
            'data'          => $data,
            'amount_invest' => $data->sum('amount'),
            'chart_enable'  => $all_invest > 0,
            'chart'         => $chart,
        ]);
    }

    public function invest(Request $request)
    {
        return redirect()->back();
        $payment_method = $request->input('payment_method');
        $amount = $request->input('amount');
        $this->validate($request, [
            'ico_type'       => 'required|in:telegram',
            'payment_method' => 'required|in:balance,mining_balance',
            'amount'         => 'required|numeric|min:5000.00|'
            .'deficiency:'.$payment_method
        ]);

        $auth = auth()->user();
        $ico = $auth->initial_coin_offerings()->create([
            'ico_type' => $request->input('ico_type'),
            'amount'   => $amount,
            'method'   => $payment_method,
        ]);

        $auth->payBalance($payment_method, $ico->amount);
        $amount = floor_f($amount / 2, 2);

        dispatch(new BinaryPointCalculate([$auth->id, $amount]));

        if ($sponsor = $auth->sponsor) {
            dispatch(new Turnovers($sponsor, $amount));
        }

        dispatch(new Histories($auth->id, 'ico', 'payments', [
            'id'     => $ico->id,
            'name'   => ucfirst($ico->ico_type),
            'method' => $ico->method,
            'amount' => formatUSD($ico->amount),
        ]));

        flash()->success('Successfully invested.')->important();

        return redirect()->back();
    }
}
