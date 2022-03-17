<?php

namespace App\Listeners;

use App\Events\EnvatoUserAuthorized;
use App\Models\Purchase;
use App\Models\User;
use App\Services\Envato\EnvatoBuyerAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncEnvatoUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EnvatoUserAuthorized  $event
     * @return void
     */
    public function handle(EnvatoUserAuthorized $event)
    {
        $oAuthUser = $event->user;
        /** @var EnvatoBuyerAPI $buyerAPI */
        $buyerAPI = app()->make(EnvatoBuyerAPI::class, ['accessToken' => $oAuthUser->token]);

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

        $ids = Purchase::where('user_id', $user->id)->get()->map->id;

        if ($ids) {
            Purchase::destroy($ids->toArray());
        }

        $purchases = $buyerAPI->getBuyerPurchases()->map(function($purchase) {

            dd($purchase);
            return new Purchase($purchase);
        });

        $user->purchases()->saveMany($purchases->all());
    }
}
