<?php

namespace Signifly\Travy;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Signifly\Travy\Support\UnmappedProp;
use Illuminate\Support\Facades\Validator;
use Signifly\Travy\Commands\ViewTravyCommand;
use Signifly\Travy\Commands\FieldTravyCommand;
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
        $this->offerPublishing();
        $this->extendValidator();
    }

    /**
     * Setup the resource publishing groups for Travy.
     *
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/travy.php' => config_path('travy.php'),
            ], 'laravel-travy');
        }
    }

    /**
     * Setup the custom validation for Travy.
     *
     * @return void
     */
    protected function extendValidator(): void
    {
        Validator::extend('unmapped_prop', function ($attribute, $value, $parameters, $validator) {
            if (! $value instanceof UnmappedProp) {
                return false;
            }

            if ($parameters) {
                /** @todo Only simple 'extended' validation is supported for now, with each rule comma-separated. */
                $rules = [$attribute => implode('|', $parameters)];

                return Validator::make([$attribute => $value->getValue()], $rules)->passes();
            }

            return true;
        });
        Validator::replacer('unmapped_prop', function ($message, $attribute, $rule, $parameters) {
            return str_replace($message, 'This prop must be unmapped or its value must be valid (see docs).', $message);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->registerCommands();
        $this->registerMacros();
    }

    /**
     * Setup the configuration for Travy.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/travy.php', 'travy');
    }

    /**
     * Register the Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ActionTravyCommand::class,
                DashboardTravyCommand::class,
                FieldTravyCommand::class,
                ResourceTravyCommand::class,
                TableTravyCommand::class,
                ViewTravyCommand::class,
            ]);
        }
    }

    /**
     * Register macros for \Illuminate\Http\Request.
     *
     * @return void
     */
    protected function registerMacros(): void
    {
        if (! Request::hasMacro('getModifier')) {
            Request::macro('getModifier', function (string $key, $default = null) {
                return $this->input("modifier.{$key}", $default);
            });
        }

        if (! Request::hasMacro('hasModifier')) {
            Request::macro('hasModifier', function (string $key) {
                return $this->has("modifier.{$key}");
            });
        }
    }
}
