<?php

namespace App\Listeners;

use App\Events\DomainDeactivated;
use Illuminate\Support\Facades\Http;

class UpdateDomainWordpressSite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DomainDeactivated $event)
    {
        $domainUrl = $event->deactivatedDomainUrl;

        Http::post("//$domainUrl");
    }
}
