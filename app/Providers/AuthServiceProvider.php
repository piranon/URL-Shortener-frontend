<?php

namespace App\Providers;

use App\Auth\ApiUserProvider;
use GuzzleHttp\Client;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->bind('GuzzleHttp\Client', function ($app) {
            return new Client(['base_uri' => $app['config']['app']['api_url']]);
        });

        $this->app['auth']->provider('api', function ($app) {
            return new ApiUserProvider($app->make('GuzzleHttp\Client'), $app['session.store']);
        });
    }
}
