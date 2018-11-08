<?php

namespace Signifly\Travy\FieldTypes;

class InputSearchFieldType extends FieldType
{
    protected $id = 'vInputSearch';

    public function value($value)
    {
        return $this->addProp('value', $value);
    }

    public function options(array $options)
    {
        return $this->addProp('options', $options);
    }
}
