<?php

namespace App\Providers;

use App\Services\Interfaces\OAuthInterface;
use App\Services\OAuth\EnvatoOAuth;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OAuthInterface::class, function() {
            return new EnvatoOAuth(Socialite::driver('envato')->stateless());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
