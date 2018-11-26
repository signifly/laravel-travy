<?php

namespace Signifly\Travy\Http\Responses;

use Illuminate\Support\Collection;

class CollectionResponse extends Response
{
    /** @var string */
    protected $model;

    /** @var \Illuminate\Support\Collection */
    protected $collection;

    public function __construct(Collection $collection, string $model)
    {
        $this->collection = $collection;
        $this->model = $model;
    }

    public function toResponse($request)
    {
        $resourceClass = $this->getHttpResourceFor($this->model);

        return $resourceClass::collection($this->collection)->toResponse($request);
    }
}
