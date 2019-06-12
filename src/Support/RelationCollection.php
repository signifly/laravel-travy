<?php

namespace Signifly\Travy\Support;

use ReflectionClass;
use ReflectionMethod;
use Signifly\Travy\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RelationCollection extends Collection
{
    /**
     * Create a new instance from a model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return self
     */
    public static function fromModel(Model $model): self
    {
        $reflection = new ReflectionClass($model);

        return static::make($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(function ($method) use ($model) {
                return $method->hasReturnType() && $method->class === get_class($model);
            })
            ->filter(function ($method) {
                return is_subclass_of($method->getReturnType()->getName(), Relation::class);
            })
            ->mapWithKeys(function ($method) use ($model) {
                $relationName = $method->name;
                return [$relationName => $model->$relationName()];
            });
    }

    /**
     * Create a new instance from a Resource.
     *
     * @param  Resource $resource
     * @return self
     */
    public static function fromResource(Resource $resource): self
    {
        return self::fromModel($resource->model());
    }

    /**
     * Get only the relations that are a BelongsToMany relation.
     *
     * @return self
     */
    public function onlyBelongsToMany(): self
    {
        return $this->filter(function ($relation) {
            return $relation instanceof BelongsToMany;
        });
    }
}
