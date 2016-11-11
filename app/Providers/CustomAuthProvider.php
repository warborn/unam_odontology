<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;

use App\Providers\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider 
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('custom', function($app, array $config) {
	       // Return an instance of             Illuminate\Contracts\Auth\UserProvider...
	        return new CustomUserProvider($app['custom.connection']);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}