<?php

namespace Signifly\Travy\Schema\Concerns;

use Exception;
use Signifly\Travy\Schema\Column;

trait HasColumns
{
    /**
     * The columns array.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Add an instance of a column.
     *
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        array_push($this->columns, $column);

        return $column;
    }

    /**
     * Overwrite columns array.
     *
     * @param  array  $fields
     * @return self
     */
    public function columns(array $fields)
    {
        $this->columns = collect($fields)
            ->mapInto(Column::class)
            ->toArray();

        return $this;
    }

    /**
     * Determine if there are any columns.
     *
     * @return bool
     */
    public function hasColumns()
    {
        return count($this->columns) > 0;
    }

    /**
     * Get the prepared columns.
     *
     * @return array
     */
    protected function preparedColumns()
    {
        return collect($this->columns)
            ->map(function ($column, $index) {
                return $column->order($index + 1)->jsonSerialize();
            })
            ->toArray();
    }
}
