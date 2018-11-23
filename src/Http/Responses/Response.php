<?php

namespace Signifly\Travy\Http\Responses;

use Exception;
use Illuminate\Contracts\Support\Responsable;

abstract class Response implements Responsable
{
    /**
     * Get the http resource for a given model.
     *
     * @param  string $model
     * @return string
     */
    protected function getHttpResourceFor(string $model)
    {
        $baseClass = class_basename($model);
        $class = "App\\Http\\Resources\\{$baseClass}";

        if (! class_exists($class)) {
            throw new Exception('Could not find a resource for ' . $baseClass);
        }

        return $class;
    }
}
