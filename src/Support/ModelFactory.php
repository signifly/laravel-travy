<?php

namespace Signifly\Travy\Support;

use ReflectionClass;

class ModelFactory
{
    public static function make(string $resourceClass, $resourceId)
    {
        $reflection = new ReflectionClass($resourceClass);
        $reflectionInstance = $reflection->newInstanceWithoutConstructor();
        $modelClass = $reflectionInstance->modelClass() ?? $resourceClass::guessModel();

        return ! is_null($resourceId)
            ? $modelClass::find($resourceId)
            : new $modelClass();
    }
}
