<?php

namespace App\Services\Interfaces;

interface OAuthInterface
{
    public function getUser();

    public function getAccessToken() : ?string;

    public function getRefreshToken() : ?string;

    public function redirect();
}
