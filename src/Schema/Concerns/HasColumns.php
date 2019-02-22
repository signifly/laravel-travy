<?php

namespace Signifly\Travy\Schema\Concerns;

use Signifly\Travy\Fields\Field;
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
     * @param \Signifly\Travy\Schema\Column $column
     */
    public function addColumn(Column $column): Column
    {
        array_push($this->columns, $column);

        return $column;
    }

    /**
     * Add column from a field.
     *
     * @param \Signifly\Travy\Fields\Field $field
     */
    public function addColumnFromField(Field $field): Column
    {
        $column = Column::make($field);

        return $this->addColumn($column);
    }

    /**
     * Overwrite columns array.
     *
     * @param  array  $fields
     * @return self
     */
    public function columns(array $fields): self
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
    public function hasColumns(): bool
    {
        return count($this->columns) > 0;
    }

    /**
     * Get the prepared columns.
     *
     * @return array
     */
    protected function preparedColumns(): array
    {
        return collect($this->columns)
            ->map(function ($column, $index) {
                return $column->setWidth()
                    ->order($index + 1)
                    ->jsonSerialize();
            })
            ->toArray();
    }
}
