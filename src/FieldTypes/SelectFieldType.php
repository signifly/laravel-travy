<?php

namespace Signifly\Travy\FieldTypes;

class SelectFieldType extends FieldType
{
    protected $id = 'vSelect';

    public function list($list)
    {
        return $this->addProp('list', $list);
    }

    public function options(array $options)
    {
        return $this->addProp('options', $options);
    }

    public function value($value)
    {
        return $this->addProp('value', $value);
    }
}
