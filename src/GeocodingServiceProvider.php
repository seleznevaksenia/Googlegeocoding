<?php

namespace Ksenia\Geocoding;

use function Composer\Autoload\includeFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Ksenia\Geocoding\Facade\GeocodingFacade;

class GeocodingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $defer = false;
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'geocoding');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/config/geocoding.php' => config_path('geocoding.php'),
        ]);
        $this->publishes([
            __DIR__.'/views' => resource_path('views'),
        ]);
        $this->publishes([
            __DIR__.'/assets' => resource_path('assets'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/Config/geocoding.php', 'geocoding');
        $this->app->make('Ksenia\Geocoding\GeocodingController');
        $this->app->bind('geocoding', function()
        {
            return new Geocoding();
        });
    }
}
