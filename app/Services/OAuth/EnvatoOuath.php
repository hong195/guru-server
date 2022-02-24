<?php

namespace App\Services\OAuth;

use App\Services\Interfaces\OAuthInterface;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Socialite\Facades\Socialite;

class EnvatoOuath implements OAuthInterface
{
    private \Laravel\Socialite\Contracts\Provider $socialiteDriver;

    public function __construct()
    {
        $this->socialiteDriver = Socialite::driver('envato');
    }

    #[NoReturn] public function handle(): void
    {
        dd($this->getUser());
    }

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
}
