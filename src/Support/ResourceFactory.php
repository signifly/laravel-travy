<?php

namespace Signifly\Travy\Support;

class ResourceFactory
{
    public static function make(string $resource)
    {
        $namespace = config('travy.resources.namespace');
        $className = studly_case(str_singular($resource));
        $resource = "{$namespace}\\{$className}";

        abort_unless(
            class_exists($resource),
            404,
            'Not Found.'
        );

        return new $resource;
    }
}
