<?php

namespace Signifly\Travy\Fields;

class Text extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text';

    /**
     * Indicates if the field should be linkable.
     *
     * @var bool
     */
    public $linkable = true;

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function options(FieldType $fieldType)
    {
        $fieldType->text($this->attribute);
    }
}
