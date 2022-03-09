<?php

namespace App\Listeners;

use App\Events\DomainActivated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncEnvatoUser
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
     * @param  \App\Events\DomainActivated  $event
     * @return void
     */
    public function handle(DomainActivated $event)
    {
        $userData = $event->userData;

        $user = User::firstOrNew([
            'nickname' => $userData->nickname,
        ])
            ->fill([
                'name' => $userData->name,
                'email' => $userData->email,
                'access_token' => $userData->token,
                'refresh_token' => $userData->refreshToken,
            ]);

        $user->password = bcrypt(123);
        $user->save();
    }
}
