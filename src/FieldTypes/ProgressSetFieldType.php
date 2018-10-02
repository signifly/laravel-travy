<?php

namespace Signifly\Travy\FieldTypes;

class ProgressSetFieldType extends FieldType
{
    protected $id = 'vProgressSet';

    public function items($items)
    {
        return $this->addProp('items', $items);
    }

    public function title($title)
    {
        return $this->addProp('title', $title);
    }

    public function percentage($percentage)
    {
        return $this->addProp('percentage', $percentage);
    }

    public function status($status)
    {
        return $this->addProp('status', $status);
    }
}
