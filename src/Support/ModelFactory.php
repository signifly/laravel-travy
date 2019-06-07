<?php

namespace Signifly\Travy\Support;

use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\CausesActivity;

class ModelFactory
{
    public static function make(string $resourceClass, $resourceId): Model
    {
        $reflection = new ReflectionClass($resourceClass);
        $reflectionInstance = $reflection->newInstanceWithoutConstructor();
        $modelClass = $reflectionInstance->modelClass();

        abort_unless(
            class_exists($modelClass),
            404,
            'Not Found.'
        );

        $model = new $modelClass();

        if (is_null($resourceId)) {
            return $model;
        }

        if (method_exists($model, 'resolveResourceBinding')) {
            return $model->resolveResourceBinding($resourceId);
        }

        return self::softDeletes($modelClass)
            ? $model->withTrashed()->findOrFail($resourceId)
            : $model->findOrFail($resourceId);
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
