<?php

namespace App\Providers;

use App\Facades\AdminAPIFacade;
use App\Facades\AdminFacadeInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AdminFacadeInterface::class, AdminAPIFacade::class);
    }
}
