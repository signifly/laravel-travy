<?php

namespace Signifly\Travy\Support;

use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RelationCollection extends Collection
{
    /**
     * Create a new instance from a model.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $model
     * @return self
     */
    public static function fromModel($model): self
    {
        $reflection = new ReflectionClass($model);

        return new static($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(function ($method) {
                return $method->hasReturnType() && $method->class === get_called_class();
            })
            ->filter(function ($method) {
                return is_subclass_of($method->getReturnType()->getName(), Relation::class);
            })
            ->mapWithKeys(function ($method) {
                $relationName = $method->name;
                return [$relationName => $this->$relationName()];
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
        return self::fromModel($resource->modelClass());
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
