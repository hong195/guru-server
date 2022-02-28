<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\OAuthInterface;
use App\Services\Interfaces\PluginActivationInterface;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class ActivationPluginController extends Controller
{
    public function __construct(private PluginActivationInterface $activationService,
    private OAuthInterface $auth)
    {
    }

    #[NoReturn] public function activate(Request $request)
    {
        $this->activationService->activate($this->auth);

    }
}
