<?php

namespace App\Services\Activation;

use App\Models\User;
use App\Services\Interfaces\OAuthInterface;
use App\Services\Interfaces\PluginActivationInterface;
use Illuminate\Support\Facades\Http;

class EnvatoPluginActivation implements PluginActivationInterface
{
    public function activate(OAuthInterface $auth)
    {
        $user = $auth->getUser();

        $user = User::firstOrCreate([
            'email' => $user->email,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'password' => bcrypt(123)
        ]);

        $userPurchasedItems = Http::withToken($user->access_token)
                ->post($this->getUserPurchaseListApiUrl())
                ->json();

        dd($userPurchasedItems);

        ///handle
        /// create record of user
    }

    protected function getUserPurchaseListApiUrl(): string
    {
        return config('envato.envato_api_url') . 'market/buyer/list-purchases';
    }
}
