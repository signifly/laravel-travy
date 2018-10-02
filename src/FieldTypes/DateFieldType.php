<?php

namespace Signifly\Travy\FieldTypes;

class DateFieldType extends FieldType
{
    protected $id = 'vDate';

    public function epoch($epoch)
    {
        return $this->addProp('epoch', $epoch);
    }
}
