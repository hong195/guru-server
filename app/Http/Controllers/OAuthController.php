<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\OAuthInterface;

class OAuthController extends Controller
{
    public function __construct(private OAuthInterface $auth){}

    public function redirect()
    {
        return $this->auth->redirect();
    }
}
