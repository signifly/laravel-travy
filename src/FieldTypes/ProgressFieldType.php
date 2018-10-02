<?php

namespace Signifly\Travy\FieldTypes;

class ProgressFieldType extends FieldType
{
    protected $id = 'vProgress';

    public function percentage($percentage)
    {
        return $this->addProp('percentage', $percentage);
    }

    public function status($status)
    {
        return $this->addProp('status', $status);
    }
}
