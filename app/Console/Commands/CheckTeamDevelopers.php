<?php

namespace App\Console\Commands;

use App\Jobs\User\CheckTeamDeveloper;
use App\User;
use Illuminate\Console\Command;

class CheckTeamDevelopers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:team-developers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check TeamDevelopers';

    public function handle()
    {
        User::where('plan', '>=', 1)->each(function ($user) {
            dispatch(new CheckTeamDeveloper($user));
        });
    }
}
