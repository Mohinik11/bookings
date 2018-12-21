<?php

namespace App\Providers;

use App\Customer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        Schema::defaultStringLength(191);

        $this->app['auth']->viaRequest('api', function ($request) {
            $header = $request->header('Api-Token');
            if($header && ($header == getenv('PUBLIC_API_KEY') || $header == getenv('PRIVATE_API_KEY'))) {
                return new Customer();
            }

            return null;
        //     if ($request->input('api_token')) {
        //         return User::where('api_token', $request->input('api_token'))->first();
        //     }
        });

    }
}
