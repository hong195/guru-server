<?php

namespace App\Services\OAuth;

use App\Events\EnvatoUserAuthorized;
use Laravel\Socialite\Contracts\Provider;

class EnvatoOAuth extends BaseOuath
{
    public function __construct(Provider $provider)
    {
        parent::__construct($provider);
    }

    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return $this->getSocialDriver()
            ->with([
                'state' => request('domain'),
            ])
            ->redirect();
    }
}
