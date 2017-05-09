<?php

namespace App\Providers;

use Twitter;
use Illuminate\Support\ServiceProvider;
use App\Services\Twitter\Clients\Thujohn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Twitter::setClient($this->app->make(Thujohn::class));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
