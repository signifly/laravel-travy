<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Contracts\Support\Responsable;

class IndexAction extends Action
{
    protected $customQuery;

    public function __construct(Request $request, Resource $resource, $customQuery = null)
    {
        parent::__construct($request, $resource);

        $this->customQuery = $customQuery;
    }

    public function handle(): Responsable
    {
        $paginator = $this->buildQueryFor($this->resource)
            ->paginate($this->request->paginationCount());

        return $this->respondForPaginator($paginator, $this->resource->modelClass());
    }

    protected function buildQueryFor($resource): QueryBuilder
    {
        $queryBuilder = QueryBuilder::for($this->customQuery ?? $resource->newQuery())
            ->allowedFilters($resource->allowedFilters())
            ->allowedIncludes($resource->allowedIncludes());

        if (! in_array('*', $resource->allowedSorts()) && ! empty($resource->allowedSorts())) {
            $queryBuilder->allowedSorts($resource->allowedSorts());
        }

        $queryBuilder->withCount($resource->withCount());

        return $queryBuilder;
    }
}
