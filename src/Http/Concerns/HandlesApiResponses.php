<?php

namespace Signifly\Travy\Http\Concerns;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HandlesApiResponses
{
    /**
     * Get the associated resource for the given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $model
     * @return string
     */
    protected function getResourceFor($model)
    {
        $baseClass = class_basename($model);
        $class = "App\\Http\\Resources\\{$baseClass}";

        if (! class_exists($class)) {
            throw new Exception('Could not find a resource for ' . $baseClass);
        }

        return $class;
    }

    /**
     * Respond for a collection.
     *
     * @param  Collection $data
     * @param  string $model
     * @return mixed
     */
    protected function respondForCollection(Collection $data, string $model)
    {
        $resourceClass = $this->getResourceFor($model);

        return $resourceClass::collection($data);
    }

    /**
     * Respond for a given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function respondForModel(Model $model)
    {
        // Model has recently been deleted, so we want to
        // respond accordingly.
        if (! $model->exists) {
            return new JsonResponse(null, 204);
        }

        if (collect(class_uses_recursive($model))->contains(SoftDeletes::class) && $model->trashed()) {
            return new JsonResponse(null, 204);
        }

        $resourceClass = $this->getResourceFor($model);
        return new $resourceClass($model);
    }

    /**
     * Respond for a paginator.
     *
     * @param  LengthAwarePaginator $data
     * @param  string $model
     * @return mixed
     */
    protected function respondForPaginator(LengthAwarePaginator $data, string $model)
    {
        $resourceClass = $this->getResourceFor($model);

        return $resourceClass::collection($data);
    }
}
