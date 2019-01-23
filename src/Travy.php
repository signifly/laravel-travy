<?php

namespace Signifly\Travy;

use Illuminate\Support\Facades\Route;

class Travy
{
    /**
     * Binds the Travy routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes($callable = null, array $options = [])
    {
        $callable = $callable ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'namespace' => '\Signifly\Travy\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callable) {
            $callable(new RouteRegistrar($router));
        });
    }
}
