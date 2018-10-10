<?php

namespace Signifly\Travy\Fields;

class Toggle extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'switch';

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
