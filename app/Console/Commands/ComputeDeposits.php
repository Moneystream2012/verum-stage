<?php

namespace App\Console\Commands;

use App\Deposit;
use App\Jobs\User\RewardDeposit;
use Illuminate\Console\Command;

class ComputeDeposits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:deposits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute deposits';

    protected $deposit;

    /**
     * Create a new command instance.
     *
     * @param \App\Deposit $deposit
     */
    public function __construct(Deposit $deposit)
    {
        parent::__construct();
        $this->deposit = $deposit;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->deposit->calculate()->get()->each(function ($deposit) {
            dispatch(new RewardDeposit($deposit));
        });
    }
}
