<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BinaryPointCalculate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;

    /**
     * BinaryPointCalculate constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //dump("Binary Point Calculate: ", $this->data, "user_point_calculate();");
        cache()->store('tarantool')->getCall('user_point_calculate', $this->data);
    }
}
