<?php

namespace App\Services\Interfaces;

interface OAuthInterface
{
    public function handle() : void;

    public function getAccessToken() : ?string;

    public function getRefreshToken() : ?string;
}
