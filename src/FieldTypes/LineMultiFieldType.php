<?php

namespace Signifly\Travy\FieldTypes;

use Closure;

class LineMultiFieldType extends FieldType
{
    protected $id = 'vLineMulti';

    public function items($items)
    {
        return $this->addProp('items', $items);
    }

    public function lineImageItems(Closure $callable)
    {
        $field = new LineImageItemsFieldType();

        $callable($field);

        $field->build();

        $this->addProp('itemFieldId', $field->getId());
        $this->addProp('itemFieldProps', $field->getProps());
    }

    public function lineImage(Closure $callable)
    {
        $field = new LineImageFieldType();

        $callable($field);

        $field->build();

        $this->addProp('itemFieldId', $field->getId());
        $this->addProp('itemFieldProps', $field->getProps());
    }
}
