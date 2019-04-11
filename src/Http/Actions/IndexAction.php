<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Spatie\QueryBuilder\QueryBuilder;

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
        $queryBuilder = QueryBuilder::for($this->defaultQuery ?? $resource->newQuery())
            ->allowedFilters($resource->allowedFilters())
            ->allowedIncludes($resource->allowedIncludes());

        if (! in_array('*', $resource->allowedSorts()) && ! empty($resource->allowedSorts())) {
            $queryBuilder->allowedSorts($resource->allowedSorts());
        }

        $queryBuilder->withCount($resource->withCount());
    }
}
