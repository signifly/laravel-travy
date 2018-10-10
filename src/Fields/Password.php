<?php

namespace Signifly\Travy\Fields;

class Password extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'inputPassword';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

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
