<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class ColorPicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'colorPicker';

    /**
     * The options to apply to the field type.
     *
     * @param FieldType $fieldType
     *
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->value($this->attribute);
    }
}
