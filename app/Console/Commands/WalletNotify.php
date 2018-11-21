<?php

namespace App\Console\Commands;

use App\ECommerce;
use App\Replenishment;
use Illuminate\Console\Command;
use RpcClient;

class WalletNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walletnotify {txid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WalletNotify TX';

    private $tx;

    /**
     * Execute the console command.
     *
     * @param RpcClient $rpcClient
     *
     * @return mixed
     */
    public function handle(RpcClient $rpcClient)
    {
        return;
        $this->tx = $this->argument('txid');
        if (ECommerce::where('txid', $this->tx)->count()) {
            return;
        }
        $rpc = $rpcClient::gettransaction([$this->tx]);
        foreach ($rpc['details'] as $item) {
            $replenishment = Replenishment::create([
                'id'          => Replenishment::generateID(),
                'user_id'     => $item['account'],
                'amount'      => $item['amount'],
                'cost_amount' => 0,
                'method'      => 'verumcoin',
                'to'          => 'mining_balance',
                'currency'    => 'VMC',
                'status'      => 'confirming',
                'payment_url' => 'https://vmcblockchain.info/tx/'.$rpc['txid'],
            ]);
            ECommerce::create([
                'replenishment_id' => $replenishment->id,
                'txid'             => $rpc['txid'],
                'category'         => $item['category'],
                'address'          => $item['address'],
                'amountUSD'        => VMCtoUSD($replenishment->amount),
                'amountVMC'        => $replenishment->amount,
            ]);
        }
    }
}
