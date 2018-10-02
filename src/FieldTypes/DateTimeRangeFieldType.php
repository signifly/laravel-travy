<?php

namespace Signifly\Travy\FieldTypes;

class DateTimeRangeFieldType extends FieldType
{
    protected $id = 'vDateTimeRange';

    public function start($start)
    {
        return $this->addProp('dateStart', $start);
    }

    public function end($end)
    {
        return $this->addProp('dateEnd', $end);
    }
}
