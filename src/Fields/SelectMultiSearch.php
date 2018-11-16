<?php

namespace Signifly\Travy\Fields;

class SelectMultiSearch extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'select-multi-search';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = [];

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function options(array $options = [])
    {
        $options = array_merge([
            'list' => null,
            'key' => 'data',
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
        $this->withMeta(['values' => $this->attribute]);
    }
}
