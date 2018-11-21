<?php

namespace App\Console\Commands;

use App\Count;
use App\Jobs\User\RewardMatchingBonus;
use App\User;
use Illuminate\Console\Command;

class ComputeMatching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:matching';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute Matching';

    private $stack;

    public function __construct()
    {
        parent::__construct();
        $this->stack = collect([]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        Count::typeIncrement('compute_matching', 1);
        $number_of = Count::typeGetCount('compute_matching');
        User::where('rank', '>=', 1)
            ->select('id', 'sponsor_id', 'rank')
            ->with(
                [
                    'sponsors.sponsors.sponsors.sponsors.sponsors.sponsors.sponsors.sponsors.sponsors.sponsors' => function (
                        $query
                    ) {
                        $query->select('id', 'sponsor_id');
                    },
                ]
            )
            ->get()
            ->map(function ($user) use ($number_of) {
                $users_id = [];
                $users_id[0][] = $user->sponsors->pluck('id')->toArray();
                $user->sponsors->map(function ($user) use (&$users_id) {
                    $users_id[1][] = $user->sponsors->pluck('id')->toArray();

                    return [
                        $user->id,
                        $user->sponsors->count(),
                        $user->sponsors->pluck('id'),
                        'sponsor' => $user->sponsors->map(function ($user) use (&$users_id) {
                            $users_id[2][] = $user->sponsors->pluck('id')->toArray();

                            return [
                                $user->id,
                                $user->sponsors->pluck('id'),

                                'sponsor' => $user->sponsors->map(function ($user) use (&$users_id) {
                                    $users_id[3][] = $user->sponsors->pluck('id')->toArray();

                                    return [
                                        $user->id,
                                        $user->sponsors->count(),
                                        $user->sponsors->pluck('id'),
                                        'sponsor' => $user->sponsors->map(function ($user) use (&$users_id) {
                                            $users_id[4][] = $user->sponsors->pluck('id')->toArray();

                                            return [
                                                $user->id,
                                                $user->sponsors->count(),
                                                $user->sponsors->pluck('id'),
                                                'sponsor' => $user->sponsors->map(function ($user) use (&$users_id) {
                                                    $users_id[5][] = $user->sponsors->pluck('id')->toArray();

                                                    return [
                                                        $user->id,
                                                        $user->sponsors->count(),
                                                        $user->sponsors->pluck('id'),
                                                        'sponsor' => $user->sponsors->map(function ($user) use (
                                                            &$users_id
                                                        ) {
                                                            $users_id[6][] = $user->sponsors->pluck('id')->toArray();

                                                            return [
                                                                $user->id,
                                                                $user->sponsors->count(),
                                                                $user->sponsors->pluck('id'),
                                                                'sponsor' => $user->sponsors->map(function ($user) use (
                                                                    &$users_id
                                                                ) {
                                                                    $users_id[7][] = $user->sponsors->pluck('id')->toArray();

                                                                    return [
                                                                        $user->id,
                                                                        $user->sponsors->count(),
                                                                        $user->sponsors->pluck('id'),
                                                                        'sponsor' => $user->sponsors->map(function (
                                                                            $user
                                                                        ) use (&$users_id) {
                                                                            $users_id[8][] = $user->sponsors->pluck('id')->toArray();

                                                                            return [
                                                                                $user->id,
                                                                                $user->sponsors->count(),
                                                                                $user->sponsors->pluck('id'),
                                                                                'sponsor' => $user->sponsors->map(function (
                                                                                    $user
                                                                                ) use (&$users_id) {
                                                                                    $users_id[9][] = $user->sponsors->pluck('id')->toArray();

                                                                                    return [
                                                                                        $user->id,
                                                                                        $user->sponsors->count(),
                                                                                        $user->sponsors->pluck('id'),
                                                                                    ];
                                                                                }),
                                                                            ];
                                                                        }),
                                                                    ];
                                                                }),
                                                            ];
                                                        }),
                                                    ];
                                                }),
                                            ];
                                        }),
                                    ];
                                }),
                            ];
                        }),
                    ];
                });
                dispatch(new RewardMatchingBonus($user, $users_id, $number_of));
            });
    }
}
