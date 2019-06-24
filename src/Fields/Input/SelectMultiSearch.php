<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class SelectMultiSearch extends SelectSearch
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-select-multi-search';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = [];

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        if ($this->endpoint) {
            $this->withOptions(['endpoint' => $this->endpoint->toArray()]);
        }

        $this->withProps([
            'values' => $this->attribute,
            'options' => $this->options(),
        ]);
    }
}
