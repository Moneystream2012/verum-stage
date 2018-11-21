<?php

namespace App\Console\Commands;

use App\Jobs\User\RankRemuneration;
use App\User;
use Illuminate\Console\Command;

class CheckPremiumRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:premium-ranks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check PremiumRanks';

    public function handle()
    {
        User::where('plan', '>=', 1)->each(function ($user) {
            dispatch(new RankRemuneration($user));
        });
    }
}
