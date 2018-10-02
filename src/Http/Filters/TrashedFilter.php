<?php

namespace Signifly\Travy\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class TrashedFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $value == true ? $query->onlyTrashed() : $query->withoutTrashed();
    }
}
