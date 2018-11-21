<?php

namespace App\Jobs\User;

use App\History;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Histories implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    private $user_id;

    private $type;

    private $category;

    private $data;

    private $created_at;

    /**
     * Histories constructor.
     *
     * @param int $user_id
     * @param $type
     * @param $category
     * @param array $data
     * @param \Carbon\Carbon|null $created_at
     */
    public function __construct(int $user_id, $type, $category, array $data, Carbon $created_at = null)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->category = $category;
        $this->data = $data;
        $this->created_at = $created_at ?? Carbon::now();
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        History::create([
            'user_id'    => $this->user_id,
            'type'       => $this->type,
            'category'   => $this->category,
            'data'       => $this->data,
            'created_at' => $this->created_at,
        ]);
    }
}
