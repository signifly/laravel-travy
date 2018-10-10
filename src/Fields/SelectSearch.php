<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class SelectSearch extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'selectSearch';

    public function options(array $options = [])
    {
        $options = array_merge([
            'endpoint' => null,
            'key' => 'data',
            'label' => null,
            'value' => 'id',
        ], $options);

        return $this->withMeta(['options' => $options]);
    }

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->value($this->attribute);
    }
}
