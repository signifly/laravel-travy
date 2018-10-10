<?php

namespace Signifly\Travy\Fields;

class InputNumber extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'inputNumber';

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function options(FieldType $fieldType)
    {
        $fieldType->value($this->attribute);
    }
}
