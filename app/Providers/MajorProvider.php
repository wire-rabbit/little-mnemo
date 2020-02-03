<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MajorSystem\MajorSystem;

class MajorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MajorSystem::class, function ($app) {
            return new MajorSystem();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
