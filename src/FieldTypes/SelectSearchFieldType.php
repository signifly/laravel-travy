<?php

namespace Signifly\Travy\FieldTypes;

class SelectSearchFieldType extends FieldType
{
    protected $id = 'vSelectSearch';

    public function options($options)
    {
        return $this->addProp('options', $options);
    }

    public function value($value)
    {
        return $this->addProp('value', $value);
    }
}
