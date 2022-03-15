<?php

namespace App\Listeners;

use App\Events\DomainActivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateDomainWordpressSite
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
     * @param  object  $event
     * @return void
     */
    public function handle(DomainActivated $event)
    {
        //to do perform request to wordpress site to set
    }
}
