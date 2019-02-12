<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class TextBold extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'textBold';

    /**
     * Indicates if the field should be linkable.
     *
     * @var bool
     */
    public $linkable = true;

    /**
     * The options to apply to the field type.
     *
     * @param FieldType $fieldType
     *
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        if ($this->component == 'textBold') {
            $fieldType->text($this->attribute);
        }

        if (in_array($this->component, ['input', 'inputNumber'])) {
            $fieldType->value($this->attribute);
        }
    }
}
