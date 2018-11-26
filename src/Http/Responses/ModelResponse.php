<?php

namespace Signifly\Travy\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelResponse extends Response
{
    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function toResponse($request)
    {
        // Model has recently been deleted, so we want to
        // respond accordingly.
        if (! $this->model->exists) {
            return new JsonResponse(null, 204);
        }

        $modelTraits = collect(class_uses_recursive($this->model));
        if ($modelTraits->contains(SoftDeletes::class) && $this->model->trashed()) {
            return new JsonResponse(null, 204);
        }

        // Otherwise return with the associated http resource
        $resourceClass = $this->getHttpResourceFor(get_class($this->model));

        return (new $resourceClass($this->model))->toResponse($request);
    }
}
