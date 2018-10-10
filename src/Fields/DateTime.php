<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class DateTime extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'dateTime';

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function options(FieldType $fieldType)
    {
        $fieldType->epoch($this->attribute);
    }
}
