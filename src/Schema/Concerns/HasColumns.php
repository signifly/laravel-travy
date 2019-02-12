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
     * Add a new column.
     *
     * @param string $name
     * @param string $label
     *
     * @return \Signifly\Travy\Column
     */
    public function addColumn($name, $label)
    {
        $column = new Column($name, $label);

        array_push($this->columns, $column);

        return $column;
    }

    /**
     * Add column from a callable definition.
     *
     * @param string $column
     */
    public function addColumnFor(string $column)
    {
        $class = new $column();

        if (!is_callable($class)) {
            throw new Exception($column.' must be callable.');
        }

        return $class($this);
    }

    /**
     * Add an instance of a column.
     *
     * @param Column $column
     */
    public function addColumnInstance(Column $column)
    {
        array_push($this->columns, $column);

        return $column;
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
        return collect($this->columns)->map(function ($column, $index) {
            return $column->order($index + 1)->toArray();
        })->all();
    }
}
