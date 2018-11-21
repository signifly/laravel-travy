<?php

namespace Signifly\Travy\Fields\Input;

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
        return $this->withMeta(['options' => $options]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['value' => $this->attribute]);
    }
}
