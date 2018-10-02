<?php

namespace Signifly\Travy;

use Illuminate\Support\ServiceProvider;
use Signifly\Travy\Commands\DefinitionMakeCommand;

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
                DefinitionMakeCommand::class,
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
