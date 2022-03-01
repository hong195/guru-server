<?php

namespace App\Services\Activation;

use App\Services\Interfaces\OAuthInterface;
use App\Services\Interfaces\PluginActivationInterface;

class EnvatoPluginActivation implements PluginActivationInterface
{
    public function activate(OAuthInterface $auth)
    {
        dd($auth->getUser(), $auth->getAccessToken());
        ///handle
        /// create record of user
    }
}
