<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class Image extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image';

    /**
     * The options to apply to the field type.
     *
     * @param FieldType $fieldType
     *
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->image($this->attribute);
    }
}