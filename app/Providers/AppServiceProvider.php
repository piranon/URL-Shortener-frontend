<?php

namespace App\Providers;

use App\Facades\AdminAPIFacade;
use App\Facades\AdminFacadeInterface;
use App\Facades\URLAPIFacade;
use App\Facades\URLFacadeInterface;
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
        $this->app->bind(URLFacadeInterface::class, URLAPIFacade::class);
    }
}
