<?php

namespace Signifly\Travy\FieldTypes;

class SelectMultiSearchFieldType extends FieldType
{
    protected $id = 'vSelectMultiSearch';

    public function options(array $options)
    {
        return $this->addProp('options', $options);
    }

    public function values($values)
    {
        return $this->addProp('values', $values);
    }
}
