<?php

namespace Signifly\Travy\FieldTypes;

class SelectSearchAddFieldType extends FieldType
{
    protected $id = 'vSelectSearchAdd';

    public function options($options)
    {
        return $this->addProp('options', $options);
    }

    public function value($value)
    {
        return $this->addProp('value', $value);
    }
}
