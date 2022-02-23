<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class ActivationPluginController extends Controller
{
    #[NoReturn] public function activate(Request $request)
    {
        dd($request);
    }
}
