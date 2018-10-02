<?php

namespace Signifly\Travy\FieldTypes;

class StatusFieldType extends FieldType
{
    protected $id = 'vStatus';

    public function status($status)
    {
        return $this->addProp('status', $status);
    }

    public function text($text)
    {
        return $this->addProp('text', $text);
    }
}
