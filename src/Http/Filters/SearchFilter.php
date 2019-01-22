<?php

namespace Signifly\Travy\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements Filter
{
    protected $columns;

    public function __construct($columns)
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
    }

    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        $value = is_array($value) ? join(',', $value) : $value;

        return $query->whereLike($this->columns, $value);
    }
}
