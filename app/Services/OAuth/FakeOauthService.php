<?php

namespace App\Services\OAuth;

use App\Services\Interfaces\OAuthInterface;

class FakeOauthService implements OAuthInterface
{
    private ?string $accessToken;

    private ?string $refreshToken;

    public function authorize(string $code): void
    {
        $this->accessToken = 'c0lQ2WLYW9qAZ9RH12cH1fJPzVWSscXP';
        $this->refreshToken = 'GBdxWsxo1CqAK9yCneH75wgkXw1q7bio';
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}
