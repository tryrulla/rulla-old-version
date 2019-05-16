<?php

namespace App\Providers;

use Aacotroneo\Saml2\Saml2ServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('LOGIN_PROVIDER', 'saml2') === 'saml2') {
            $this->app->register(Saml2ServiceProvider::class);
        }
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
