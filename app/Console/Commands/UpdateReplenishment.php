<?php

namespace App\Console\Commands;

use App\Replenishment;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Illuminate\Console\Command;

class UpdateReplenishment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:replenishment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Replenishment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        CoinGate::config([
            'app_id'     => '5507',
            'api_key'    => '8aPuGKxTwVAr9ycZ3n2zvN',
            'api_secret' => 'lgTBcsASv7a8QjxO1kC5nyHdI0qVJmeE',
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Replenishment::whereStatus('pending')->get()->each(function (Replenishment $item) {
            $order = Order::find($item->payment_id);
            $item->status = $order->status;
            $item->save();
            if( $order->status == 'paid'){
                $item->pay();
            }

            dump($order, $order->status, $item->to);
        });


    }
}
