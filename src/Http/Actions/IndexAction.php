<?php

namespace Signifly\Travy\Http\Actions;

use Signifly\Travy\Resource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexAction extends Action
{
    protected $defaultQuery;

    public function __construct(Request $request, Resource $resource, $defaultQuery = null)
    {
        parent::__construct($request, $resource);

        $this->defaultQuery = $defaultQuery;
    }

    public function handle() : LengthAwarePaginator
    {
        return $this->buildQueryFor($this->resource)
            ->paginate($this->request->paginationCount());
    }

    protected function buildQueryFor($resource)
    {
        return QueryBuilder::for($this->defaultQuery ?? $resource->newQuery())
            ->allowedFilters($resource->allowedFilters())
            ->allowedIncludes($resource->allowedIncludes())
            ->allowedSorts($resource->allowedSorts())
            ->withCount($resource->withCount());
    }
}
