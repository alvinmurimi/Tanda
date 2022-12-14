<?php

namespace Alvoo\Tanda;

use Illuminate\Support\ServiceProvider;
use Alvoo\Tanda\Console\Install;

class TandaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            //publish the config file
            $this->publishes([
              __DIR__.'/../config/tanda.php' => config_path('tanda.php'),
          ], 'tanda-config');

            // Register commands
            $this->commands([
            Install::class,
          ]);
        }
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tanda.php', 'tanda');

        $this->app->bind('alvoo-tanda', function () {
            return new Tanda();
        });
    }
}