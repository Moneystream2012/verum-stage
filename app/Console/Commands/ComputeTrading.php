<?php

namespace App\Console\Commands;

use App\Jobs\User\RewardTrading;
use App\Trading;
use Illuminate\Console\Command;

class ComputeTrading extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:trading';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute trading';

    protected $trading;

    /**
     * Create a new command instance.
     *
     * @param Trading $trading
     */
    public function __construct(Trading $trading)
    {
        parent::__construct();
        $this->trading = $trading;
    }

    public function handle(){
        $this->trading->calculate()->get()->each(function ($trading) {
            dispatch(new RewardTrading($trading));
        });
    }
}
