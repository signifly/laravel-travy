<?php

namespace Signifly\Travy\FieldTypes;

class DateRangeFieldType extends FieldType
{
    protected $id = 'vDateRange';

    public function start($start)
    {
        return $this->addProp('dateStart', $start);
    }

    public function end($end)
    {
        return $this->addProp('dateEnd', $end);
    }
}
