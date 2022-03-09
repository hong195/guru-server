<?php

namespace App\Services\OAuth;

use App\Services\Interfaces\OAuthInterface;
use Laravel\Socialite\Facades\Socialite;

abstract class BaseOuath implements OAuthInterface
{
    public function __construct(private \Laravel\Socialite\Contracts\Provider $socialiteDriver){}

    public function getAccessToken()
    {
        return $this->getUser()->token;
    }

    public function getRefreshToken()
    {
        return $this->getUser()->refreshToken;
    }

    public function getUser(): \Laravel\Socialite\Contracts\User
    {
        return $this->socialiteDriver->user();
    }

    public function getSocialDriver(): \Laravel\Socialite\Contracts\Provider
    {
        return $this->socialiteDriver;
    }

    public function redirect()
    {
        return $this->getSocialDriver()->redirect();
    }

    /**
     * @return \Laravel\Socialite\Contracts\Provider
     */
    public function getSocialiteDriver(): \Laravel\Socialite\Contracts\Provider
    {
        return $this->socialiteDriver;
    }
}
