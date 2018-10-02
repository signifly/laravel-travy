<?php

namespace Signifly\Travy\FieldTypes;

class SelectMultiSearchAddFieldType extends FieldType
{
    protected $id = 'vSelectMultiSearchAdd';

    public function options(array $options)
    {
        return $this->addProp('options', $options);
    }

    public function values($values)
    {
        return $this->addProp('values', $values);
    }
}
