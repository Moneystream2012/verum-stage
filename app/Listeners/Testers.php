<?php

namespace App\Listeners;

use App\Events\Tester;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Testers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Tester  $event
     * @return void
     */
    public function handle(Tester $event)
    {
        //
    }
}
