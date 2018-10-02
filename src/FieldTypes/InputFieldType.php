<?php

namespace Signifly\Travy\FieldTypes;

class InputFieldType extends FieldType
{
    protected $id = 'vInput';

    public function value($value)
    {
        return $this->addProp('value', $value);
    }
}
