<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WalletNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WalletNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->data['account']);
        $user->notify(new WalletNotification($this->data));

        switch ($this->data['category']) {
            case 'send':
                $amount = abs($this->data['amount'] + $this->data['fee']);
                $user->increment('balance_sent', $amount);
                break;
            case 'receive':
                $amount = $this->data['amount'];
                $user->increment('balance_received', $amount);
                break;
        }
    }
}
