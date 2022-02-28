<?php

namespace App\Services\Interfaces;

interface PluginActivationInterface
{
    public function activate(OAuthInterface $auth) ;
}
