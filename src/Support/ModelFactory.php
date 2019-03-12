<?php

namespace Signifly\Travy\Support;

use ReflectionClass;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelFactory
{
    public static function make(string $resourceClass, $resourceId)
    {
        $reflection = new ReflectionClass($resourceClass);
        $reflectionInstance = $reflection->newInstanceWithoutConstructor();
        $modelClass = $reflectionInstance->modelClass() ?? $resourceClass::guessModel();

        abort_unless(
            class_exists($modelClass),
            404,
            'Not Found.'
        );

        if (is_null($resourceId)) {
            return new $modelClass();
        }

        if (self::softDeletes($modelClass)) {
            return $modelClass::withTrashed()->findOrFail($resourceId);
        }

        return $modelClass::findOrFail($resourceId);
    }

    /**
     * Determine if a model uses soft deletes.
     *
     * @return bool
     */
    public static function softDeletes(string $modelClass)
    {
        return in_array(
            SoftDeletes::class,
            class_uses_recursive($modelClass)
        );
    }
}
