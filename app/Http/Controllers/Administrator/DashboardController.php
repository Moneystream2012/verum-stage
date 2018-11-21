<?php

namespace App\Http\Controllers\Administrator;

use App\Amount;
use App\Compute;
use App\Deposit;
use App\Http\Controllers\Controller;
use App\InitialCoinOffering;
use App\Replenishment;
use App\Reward;
use App\Trading;
use App\Transfer;
use App\User;
use App\Withdraw;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::select('active', 'balance', 'mining_balance')->get();
        $deposits = Deposit::all();
        $withdraws = Withdraw::all();
        $transfers = Transfer::all();
        $replenishments = Replenishment::whereStatus('paid')->get();
        $ico = InitialCoinOffering::all();

        $rewards = Reward::groupBy('from_type')
            ->select('from_type', \DB::raw('sum(amount) as sum'))
            ->pluck('sum', 'from_type');

        $computes = Compute::where('amount', '>', 0)
            ->groupBy('from')
            ->select('from', \DB::raw('sum(amount) as sum'))
            ->pluck('sum', 'from');

        $deposits_amount = $deposits->groupBy('plan')->sum(function ($item) {
            return $item->first()->invest * $item->count();
        });

        $remains_payout_deposits = cache()->remember('remains_payout_deposits', 10, function () {
            $sum = [
                'personal' => 0,
                'all'      => 0,
            ];

            Deposit::where('active', true)->get()
                ->each(function (Deposit $deposit) use (&$sum) {
                    $personal = $deposit->invest - $deposit->profit;
                    $sum['personal'] += $personal > 0 ? $personal : 0;
                    $sum['all'] += ($deposit->payout + $deposit->invest) - $deposit->profit;
                });

            return $sum;
        });

        $withdraw_processing = $withdraws->where('status', Withdraw::STATUS_PROCESSING)->groupBy('to_method')->map(function (
            $item
        ) {
            return $item->sum('amount');
        });

        $cold_balance_deposits = Amount::where('type','LIKE',"%cold_balance_%")->sum('amount');
        $trading = Trading::whereStatus(Trading::ACTIVE)->select('invest', 'profit')->get();

        $data = [
            'users'          => [
                'count'              => $users->count(),
                'balance_usd'        => $users->sum('balance'),
                'balance_vmc'        => USDtoVMC($users->sum('balance')),
                'mining_balance_usd' => VMCtoUSD($users->sum('mining_balance')),
                'mining_balance_vmc' => $users->sum('mining_balance'),
            ],
            'withdraws'      => [
                'amount_success'     => $withdraws->where('status', Withdraw::STATUS_SUCCESS)->sum('amount'),
                'amount_processing'  => $withdraw_processing,
                'commission'         => $withdraws->where('status', Withdraw::STATUS_SUCCESS)->sum('cost_amount'),
            ],
            'transfers'      => [
                'amount'     => $transfers->sum('amount'),
                'commission' => $transfers->sum('cost_amount'),
            ],
            'replenishments' => [
                'amount'     => [
                    'usd' => $replenishments->where('currency', 'USD')->sum('amount'),
                    'btc' => $replenishments->where('currency', 'BTC')->sum('amount'),
                    'vmc' => $replenishments->where('currency', 'VMC')->sum('amount'),
                ],
                'commission' => [
                    'usd' => $replenishments->where('currency', 'USD')->sum('cost_amount'),
                    'btc' => $replenishments->where('currency', 'BTC')->sum('cost_amount'),
                    'vmc' => $replenishments->where('currency', 'VMC')->sum('cost_amount'),
                ],
            ],
            'deposits'       => [
                'cold_balance' => $cold_balance_deposits,
                'amount' => $deposits_amount,
            ],
            'rewards'        => [
                'deposit' => $rewards['deposit'] ?? 0.00,
            ],
            'computes'       => [
                'binary' => $computes['binary'] ?? 0.00,
                'direct' => $computes['direct'] ?? 0.00,
            ],
            'remains'        => [
                'payout_deposits_personal' => $remains_payout_deposits['personal'],
                'payout_deposits_all'      => $remains_payout_deposits['all'],
            ],
            'ico'            => [
                'amount' => [
                    'telegram' => $ico
                        ->where('ico_type', 'telegram')
                        ->sum('amount'),
                ],
            ],
            'commissions'    => 0.00,
            'trading' => [
                'invest' => $trading->sum('invest'),
                'profit' =>  $trading->sum('profit'),
                'percent' => Trading::getPercentPayout(),
            ],
        ];

        $data['commissions_usd'] = $data['withdraws']['commission']
            + $data['transfers']['commission']
            + $data['replenishments']['commission']['usd'];
        $data['commissions_btc'] = $data['replenishments']['commission']['btc'];
        $data['commissions_vmc'] = $data['replenishments']['commission']['vmc'];

        return view('administrator.dashboard', ['data' => (object) $data]);
    }
}
