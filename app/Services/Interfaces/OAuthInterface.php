<?php

namespace App\Services\Interfaces;

interface OAuthInterface
{
    public function getUser();

    public function getAccessToken();

    public function getRefreshToken();

    public function redirect();
}
