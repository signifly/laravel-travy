<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class SelectSearch extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-select-search';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function options(array $options = [])
    {
        $options = array_merge([
            'endpoint' => null,
            'key' => 'data',
            'value' => 'id',
            'label' => null,
            'itemKey' => 'data',
            'itemValue' => 'id',
        ], $options);

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
