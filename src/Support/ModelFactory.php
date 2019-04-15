<?php

namespace Signifly\Travy\Support;

use ReflectionClass;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\CausesActivity;

class ModelFactory
{
    public static function make(string $resourceClass, $resourceId)
    {
        $reflection = new ReflectionClass($resourceClass);
        $reflectionInstance = $reflection->newInstanceWithoutConstructor();
        $modelClass = $reflectionInstance->modelClass();

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
     * Determine if a model uses causes activity.
     *
     * @return bool
     */
    public static function causesActivity(string $modelClass)
    {
        return in_array(
            CausesActivity::class,
            class_uses_recursive($modelClass)
        );
    }

    /**
     * Determine if a model uses logs activity.
     *
     * @return bool
     */
    public static function logsActivity(string $modelClass)
    {
        return in_array(
            LogsActivity::class,
            class_uses_recursive($modelClass)
        );
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
