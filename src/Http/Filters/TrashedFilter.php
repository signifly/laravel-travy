<?php

namespace Signifly\Travy\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class TrashedFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $value == true ? $query->onlyTrashed() : $query->withoutTrashed();
    }
}
