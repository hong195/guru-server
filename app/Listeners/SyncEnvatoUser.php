<?php

namespace App\Listeners;

use App\Events\EnvatoUserAuthorized;
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
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  \App\Events\EnvatoUserAuthorized  $event
     * @return void
     */
    public function handle(EnvatoUserAuthorized $event)
    {
        $oAuthUser = $event->user;

        $user = User::firstOrNew([
            'nickname' => $oAuthUser->nickname,
        ])
            ->fill([
                'name' => $oAuthUser->name,
                'email' => $oAuthUser->email,
                'access_token' => $oAuthUser->token,
                'refresh_token' => $oAuthUser->refreshToken,
            ]);

        $user->password = bcrypt(123);
        $user->save();
    }
}