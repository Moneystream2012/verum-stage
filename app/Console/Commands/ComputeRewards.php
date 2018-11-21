<?php

namespace App\Console\Commands;

use App\Compute;
use App\Count;
use App\Jobs\User\Histories;
use App\Turnover2;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ComputeRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:rewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute rewards';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Count::typeIncrement('compute_rewards', 1);
        $history = [
            'number_of' => Count::typeGetCount('compute_rewards'),
            'binary-to' => 'balance',
            'direct-to' => 'balance',
        ];

        /* BINARY COMPUTE*/
        $binary_compute = cache()->store('tarantool')->getCall('binary_compute');
        foreach ($binary_compute as $data) {
            $point_left = $data[1];
            $point_right = $data[2];
            $reward = $data[3];
            $amount = 0;
            $binary_bonus = 0;
            if ($reward > 0) {
                $user = User::find($data[0]);
                $binary_bonus = $user->product['mlm_binary_bonus'];
                $amount = round($reward * $binary_bonus, 2);
                $amount = $amount > (float) $user->product['price'] ? (float) $user->product['price'] : $amount;
                $user->investBalance($history['binary-to'], $amount);
                $user->increment('binary_total', $amount);
                $user->computes()->create([
                    'from'        => 'binary',
                    'to'          => $history['binary-to'],
                    'number_of'   => $history['number_of'],
                    'point_left'  => $point_left,
                    'point_right' => $point_right,
                    'reward'      => $reward,
                    'amount'      => $amount,
                    'rank'        => $user->rank,
                    'plan'        => $user->plan,
                    'bonus'       => $binary_bonus,
                    'status'      => Compute::STATUS_PROCESSING,
                ]);
            }

            $history[$data[0]]['binary-point_left'] = $point_left;
            $history[$data[0]]['binary-point_right'] = $point_right;
            $history[$data[0]]['binary-reward'] = $reward;
            $history[$data[0]]['binary-amount'] = $amount;
            $history[$data[0]]['binary-bonus'] = $binary_bonus * 100;

            dump('BINARY COMPUTE => '.$data[0], 'amount => '.$amount, $data);
        }

        /* DIRECT COMPUTE*/
        $turnovers = Turnover2::all();
        foreach ($turnovers as $turnover) {
            $reward = $turnover->direct_week;
            $amount = 0;
            $direct_bonus = 0;

            if ($reward > 0) {
                $user = $turnover->user;
                $direct_bonus = $user->product['mlm_direct_bonus'];
                $amount = round($reward * $direct_bonus, 2);
                $amount = $amount > (float) $user->product['price'] ? (float) $user->product['price'] : $amount;
                $user->investBalance($history['direct-to'], $amount);
                $user->computes()->create([
                    'from'        => 'direct',
                    'to'          => $history['direct-to'],
                    'point_left'  => 0,
                    'point_right' => 0,
                    'number_of'   => $history['number_of'],
                    'reward'      => $reward,
                    'amount'      => $amount,
                    'plan'        => $user->plan,
                    'rank'        => $user->rank,
                    'bonus'       => $direct_bonus,
                    'status'      => Compute::STATUS_PROCESSING,
                ]);
            }

            $turnover->direct_week = 0;
            $turnover->direct_total += $amount;
            $turnover->calculate_at = Carbon::now();
            $turnover->save();

            $history[$turnover->user_id]['direct-reward'] = $reward;
            $history[$turnover->user_id]['direct-amount'] = $amount;
            $history[$turnover->user_id]['direct-bonus'] = $direct_bonus * 100;

            dump('DIRECT COMPUTE => '.$turnover->user_id, 'amount => '.$amount);
        }

        /*HISTORY USERS*/
        $users = User::where('plan', '>', 0)->select('id')->get();
        foreach ($users as $user) {
            $item = $history[$user->id];
            $data = [
                'binary-to'          => $history['binary-to'],
                'binary-point_left'  => formatUSD($item['binary-point_left'] ?? 0.00),
                'binary-point_right' => formatUSD($item['binary-point_right'] ?? 0.00),
                'binary-amount'      => formatUSD($item['binary-amount'] ?? 0.00),
                'binary-bonus'       => $item['binary-bonus'] ?? 0,
                'direct-to'          => $history['direct-to'],
                'direct-reward'      => formatUSD($item['direct-reward'] ?? 0.00),
                'direct-amount'      => formatUSD($item['direct-amount'] ?? 0.00),
                'direct-bonus'       => $item['direct-bonus'] ?? 0,
                'number_of'          => $history['number_of'],
            ];
            dispatch(new Histories($user->id, 'compute_rewards', 'profits', $data));
        }
    }
}
