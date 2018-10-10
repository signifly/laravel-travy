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

        return $query->where(function ($query) use ($value) {
            foreach ($this->columns as $column) {
                if (str_contains($column, '.')) {
                    list($relation, $columnName) = explode('.', $column);
                    $query->orWhereHas(camel_case($relation),
                        function ($query) use ($columnName, $value) {
                            $query->where($query->qualifyColumn($columnName), 'LIKE', "%{$value}%");
                        }
                    );
                    continue;
                }

                $query->orWhere($query->qualifyColumn($column), 'LIKE', "%{$value}%");
            }
        });
    }
}
