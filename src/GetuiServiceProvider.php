<?php

namespace Cncal\Getui;

use Illuminate\Support\ServiceProvider;

class GetuiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/getui.php' => config_path('getui.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('getui', function($app) {
            return new Getui($app['config']);
        });
    }
}
