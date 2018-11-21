<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\User\RankRemuneration;
use App\Trading;
use ConsoleTVs\Charts\Facades\Charts;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $deposits = $user->deposits()->where('active', true)->select('invest')->get();
        $tradings= $user->tradings()->where('status', Trading::ACTIVE)->select('invest')->get();

        return view('unify.personal-office.dashboard', [
            'chart'          => $this->get_chart_price_vmc(),
            'deposits' => [
                'invest' => $deposits->sum('invest'),
                'count' => $deposits->count(),
            ],
            'tradings' => [
                'invest' => $tradings->sum('invest'),
                'count' => $tradings->count(),
            ],
            'turnover' => $user->turnover2s,
        ]);
    }

    private function get_chart_price_vmc()
    {
        $chart = Charts::multi('area', 'morris')
            ->height(187)
            ->colors(['#4266b2', '#efa406'])
            ->labels(['07.11.2017', '08.11.2017', '10.01.2018', '04.02.2018', '05.02.2018', '11.03.2018'])
            ->dataset('USD', [0.10, 0.11, 0.12, 0.13, 0.14, config('mlm.currencies.VMC.USD')])
            ->dataset('BTC', [0.00005, 0.00006, 0.00007, 0.00008,0.00009, config('mlm.currencies.VMC.BTC')]);
        return $chart;
    }

    private function get_next_rank($user)
    {
        $next_rank = [
            'binary'    => 0,
            'direct'    => 0,
            'text_rank' => null,
            'reward' => 0,
        ];
        $rank = $user->rank < 2 ? 1 : $user->rank;
        $rank++;
        if ($rank > 6) {
            return $next_rank;
        }
        $premium_rank = RankRemuneration::PREMIUM_RANK[$rank];
        $turnover_direct = $premium_rank['turnover_direct'] - ($user->turnover2s->direct_all ?? 0);
        $next_rank['direct'] = $turnover_direct > 0 ? $turnover_direct : 0;
        $turnover_binary = $premium_rank['turnover_binary'] - $user->binary_lower_branch;
        $next_rank['binary'] = $turnover_binary > 0 ? $turnover_binary : 0;
        $next_rank['text_rank'] = trans('rank.'.$rank);
        $next_rank['reward'] = $premium_rank['reward'];

        return $next_rank;
    }
}
