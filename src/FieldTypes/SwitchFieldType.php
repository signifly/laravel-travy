<?php

namespace Signifly\Travy\FieldTypes;

class SwitchFieldType extends FieldType
{
    protected $id = 'vSwitch';

    public function value($value)
    {
        return $this->addProp('value', $value);
    }
}
