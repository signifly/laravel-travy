<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class Toggle extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'switch';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = false;

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
