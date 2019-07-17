<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Contracts\Support\Responsable;

class IndexAction extends Action
{
    /**
     * The base query.
     *
     * @var string|Illuminate\Database\Query\Builder|null
     */
    protected $baseQuery;

    public function __construct(Request $request, Resource $resource, $baseQuery = null)
    {
        parent::__construct($request, $resource);

        $this->baseQuery = $baseQuery;
    }

    public function handle(): Responsable
    {
        $paginator = $this->buildQueryFor($this->resource)
            ->paginate($this->request->paginationCount());

        return $this->respond($paginator);
    }

    protected function buildQueryFor($resource): QueryBuilder
    {
        $queryBuilder = QueryBuilder::for($this->baseQuery ?? $resource->newQuery())
            ->allowedFilters($resource->allowedFilters())
            ->allowedIncludes($resource->allowedIncludes());

        if (! in_array('*', $resource->allowedSorts()) && ! empty($resource->allowedSorts())) {
            $queryBuilder->allowedSorts($resource->allowedSorts());
        }

        $queryBuilder->withCount($resource->withCount());

        return $queryBuilder;
    }
}
