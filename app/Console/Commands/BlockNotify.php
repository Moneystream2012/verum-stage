<?php

namespace App\Console\Commands;

use App\ECommerce;
use Illuminate\Console\Command;
use RpcClient;

class BlockNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocknotify {hash}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BlockNotify Hash';

    private $hash;

    /**
     * Execute the console command.
     *
     * @param RpcClient $rpcClient
     *
     * @return mixed
     */
    public function handle(RpcClient $rpcClient)
    {
        $this->hash = $this->argument('hash');
        dump(['BLOCKNOTIFY' =>  $this->hash]);
        ECommerce::where('paid', false)->get()->each(function (ECommerce $item) {
            $item->confirmations++;
            if ($item->confirmations >= 3) {
                $item->paid = true;
                $item->replenishment->pay();
                $item->replenishment->update(['status' => 'paid']);
            }

            $item->save();
        });
    }
}
