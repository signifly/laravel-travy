<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Str;
use Signifly\Travy\Resource;

class ResourceFactory
{
    public static function make(string $resource, $resourceId = null): Resource
    {
        $namespace = config('travy.resources.namespace');
        $className = Str::studly(Str::singular($resource));
        $resource = "{$namespace}\\{$className}";

        abort_unless(
            class_exists($resource),
            404,
            'Not Found.'
        );

        $model = ModelFactory::make($resource, $resourceId);

        return new $resource($model);
    }
}
