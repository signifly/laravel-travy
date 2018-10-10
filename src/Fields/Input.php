<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class Input extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input';

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
