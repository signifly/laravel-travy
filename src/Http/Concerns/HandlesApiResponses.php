<?php

namespace Signifly\Travy\Http\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Signifly\Travy\Http\Responses\ModelResponse;
use Signifly\Travy\Http\Responses\PaginatorResponse;
use Signifly\Travy\Http\Responses\CollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HandlesApiResponses
{
    /**
     * Respond for a collection.
     *
     * @param  Collection $data
     * @param  string $model
     * @return mixed
     */
    protected function respondForCollection(Collection $data, string $model)
    {
        return new CollectionResponse($data, $model);
    }

    /**
     * Respond for a given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function respondForModel(Model $model)
    {
        return new ModelResponse($model);
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
        return new PaginatorResponse($data, $model);
    }
}
