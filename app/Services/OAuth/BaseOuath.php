<?php

namespace App\Services\OAuth;

use App\Services\Interfaces\OAuthInterface;
use Laravel\Socialite\Facades\Socialite;

abstract class BaseOuath implements OAuthInterface
{
    public function __construct(private \Laravel\Socialite\Contracts\Provider $socialiteDriver){}

    public function getAccessToken(): ?string
    {
        return $this->getUser()->accessTokenResponseBody;
    }

    public function getRefreshToken(): ?string
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

    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
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
