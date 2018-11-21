<?php

namespace Signifly\Travy\Fields\Input;

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
            'itemKey' => 'data',
            'label' => null,
            'value' => 'id',
        ], $options);

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
