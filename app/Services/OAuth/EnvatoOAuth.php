<?php

namespace App\Services\OAuth;

use App\Services\Interfaces\OAuthInterface;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;
use Laravel\Socialite\Facades\Socialite;

class EnvatoOAuth extends BaseOuath
{
    #[Pure] public function __construct(\Laravel\Socialite\Contracts\Provider $provider)
    {
        parent::__construct($provider);
    }

    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return $this->getSocialDriver()
            ->with([
                'state' => request('domain')
            ])
            ->redirect();
    }
}
