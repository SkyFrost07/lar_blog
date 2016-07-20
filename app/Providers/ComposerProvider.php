<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('manage.parts.menubar', 'App\Composers\AdMenuComposer');
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
