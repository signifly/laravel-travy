<?php

namespace Signifly\Travy\Support;

use Closure;
use Illuminate\Support\Str;
use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Column;

class ColumnResolver
{
    /** @var \Signifly\Travy\Schema\Column */
    protected $column;

    /** @var \Signifly\Travy\Fields\Field */
    protected $field;

    /**
     * Resolve the field.
     *
     * @param  \Signifly\Travy\Fields\Field  $field
     * @return \Signifly\Travy\Schema\Column
     */
    public function resolve(Field $field)
    {
        $this->field = $field;

        $this->initColumn();
        $this->applyFieldTypeOptions();
        $this->applyColumnOptions();

        return $this->column;
    }

    protected function applyColumnOptions()
    {
        // Set sortable option
        if ($this->field->sortable) {
            $this->column->sortable($this->field->attribute);
        }

        // Set column width
        if ($this->field->columnWidth) {
            $this->column->width($this->field->columnWidth);
        }
    }

    /**
     * Apply field type options.
     *
     * @return self
     */
    protected function applyFieldTypeOptions()
    {
        $method = 'get' . Str::studly($this->field->component) . 'Options';

        if (method_exists($this, $method)) {
            $this->column->fieldType(
                $this->field->component,
                Closure::fromCallable([$this, $method])
            );
        }

        return $this;
    }

    /**
     * Instantiate a column from a field object.
     *
     * @return self
     */
    protected function initColumn()
    {
        $this->column = new Column(
            $this->field->attribute,
            $this->field->name
        );

        return $this;
    }

    /**
     * Get options for the text field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    protected function getTextOptions($fieldType)
    {
        $fieldType->text($this->field->attribute);
    }
}
