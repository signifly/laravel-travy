<?php

namespace Signifly\Travy\FieldTypes;

class DatePickerFieldType extends FieldType
{
    protected $id = 'vDatePicker';

    public function date($date)
    {
        return $this->addProp('date', $date);
    }
}
