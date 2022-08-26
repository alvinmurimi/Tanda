<?php

namespace Alvo\Tanda;

use Illuminate\Support\ServiceProvider;
use Alvo\Tanda\Console\Install;

class TandaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // require __DIR__.'/routes/web.php';
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            //publish the config files
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('tanda.php'),
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

        $this->app->bind('tanda-mpesa', function () {
            return new Tanda();
        });
    }
}