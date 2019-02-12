<?php

namespace Signifly\Travy\Support;

use Closure;
use Signifly\Travy\Fields\Field;
use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Schema\Column;

class ColumnResolver
{
    /** @var \Signifly\Travy\Schema\Column */
    protected $column;

    /** @var \Signifly\Travy\Fields\Field */
    protected $field;

    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /**
     * Create a new column resolver.
     *
     * @param \Signifly\Travy\Http\Requests\TravyRequest $request
     */
    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Resolve the field.
     *
     * @param \Signifly\Travy\Fields\Field $field
     *
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

    /**
     * Apply column options.
     *
     * @return void
     */
    protected function applyColumnOptions()
    {
        // Set sortable option
        if ($this->field->sortable) {
            $this->column->sortable($this->field->sortBy);
        }

        // Set column width
        if ($this->field->columnWidth) {
            $this->column->width($this->field->columnWidth);
        }
    }

    /**
     * Apply field type options.
     *
     * @return void
     */
    protected function applyFieldTypeOptions()
    {
        $method = 'applyOptions';

        if (method_exists($this->field, $method)) {
            $this->column->fieldType(
                $this->field->component,
                Closure::fromCallable([$this->field, $method])
            );

            $this->column->tapFieldType(function ($fieldType) {
                foreach ($this->field->meta() as $key => $value) {
                    $fieldType->$key($value);
                }

                if (!$this->field->linkable) {
                    return;
                }

                $fieldType->action($this->field->linksTo ?? "/t/{$this->request->resourceKey()}/{id}");
            });
        }
    }

    /**
     * Instantiate a column from a field object.
     *
     * @return void
     */
    protected function initColumn()
    {
        $this->column = new Column(
            $this->field->attribute,
            $this->field->name
        );
    }
}
