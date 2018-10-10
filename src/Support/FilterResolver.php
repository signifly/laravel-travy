<?php

namespace Signifly\Travy\Support;

use Closure;
use Illuminate\Support\Str;
use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Filter;
use Signifly\Travy\Http\Requests\TravyRequest;

class FilterResolver
{
    /** @var \Signifly\Travy\Schema\Filter */
    protected $filter;

    /** @var \Signifly\Travy\Fields\Field */
    protected $field;

    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /**
     * Create a new filter resolver.
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
     * @param  \Signifly\Travy\Fields\Field  $field
     * @return \Signifly\Travy\Schema\Filter
     */
    public function resolve(Field $field)
    {
        $this->field = $field;

        $this->initFilter();
        $this->applyFieldTypeOptions();

        return $this->filter;
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
            $this->filter->fieldType(
                $this->field->component,
                Closure::fromCallable([$this->field, $method])
            );

            $this->filter->tapFieldType(function ($fieldType) {
                foreach ($this->field->meta() as $key => $value) {
                    $fieldType->$key($value);
                }
            });

            // Default data for filter
            $this->filter->withData($this->field->attribute, '');
        }
    }

    /**
     * Instantiate a filter from a field object.
     *
     * @return void
     */
    protected function initFilter()
    {
        $this->filter = new Filter(
            $this->field->attribute,
            $this->field->name
        );
    }
}
