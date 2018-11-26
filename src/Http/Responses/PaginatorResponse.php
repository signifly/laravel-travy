<?php

namespace Signifly\Travy\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatorResponse extends Response
{
    /** @var string */
    protected $model;

    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator */
    protected $paginator;

    public function __construct(LengthAwarePaginator $paginator, string $model)
    {
        $this->paginator = $paginator;
        $this->model = $model;
    }

    public function toResponse($request)
    {
        $resourceClass = $this->getHttpResourceFor($this->model);

        return $resourceClass::collection($this->paginator);
    }
}
