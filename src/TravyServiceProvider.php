<?php

namespace Signifly\Travy;

use Illuminate\Support\ServiceProvider;
use Signifly\Travy\Commands\ViewTravyCommand;
use Signifly\Travy\Commands\TableTravyCommand;
use Signifly\Travy\Commands\ActionTravyCommand;
use Signifly\Travy\Commands\ResourceTravyCommand;
use Signifly\Travy\Commands\DashboardTravyCommand;

class TravyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/travy.php' => config_path('travy.php'),
        ], 'laravel-travy');

        // Merge configs
        $this->mergeConfigFrom(__DIR__.'/../config/travy.php', 'travy');

        // Load commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ActionTravyCommand::class,
                DashboardTravyCommand::class,
                ResourceTravyCommand::class,
                TableTravyCommand::class,
                ViewTravyCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
