<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Search extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-search';

    public function options(array $options)
    {
        return $this->withProps(['options' => $options]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['value' => $this->attribute]);
    }
}
