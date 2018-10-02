<?php

namespace Signifly\Travy\FieldTypes;

class InputNumberFieldType extends FieldType
{
    protected $id = 'vInputNumber';

    public function value($value)
    {
        return $this->addProp('value', $value);
    }

    public function unit($unit)
    {
        return $this->addProp('unit', $unit);
    }
}
