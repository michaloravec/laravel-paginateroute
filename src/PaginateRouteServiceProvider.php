<?php

namespace MichalOravec\PaginateRoute;

use Illuminate\Support\ServiceProvider;

class PaginateRouteServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/paginateroute'),
        ], 'lang');

        $this->publishes([
            __DIR__.'/../config/paginateroute.php' => config_path('paginateroute.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('paginateroute', 'MichalOravec\PaginateRoute\PaginateRoute');
    }
}
