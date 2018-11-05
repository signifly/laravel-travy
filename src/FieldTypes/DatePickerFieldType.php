<?php

namespace Signifly\Travy\FieldTypes;

class DatePickerFieldType extends FieldType
{
    protected $id = 'vDatePicker';

    public function date($date)
    {
        return $this->addProp('date', $date);
    }

    public function format($format)
    {
        return $this->addProp('format', $format);
    }

    public function formatValue($formatValue)
    {
        return $this->addProp('formatValue', $formatValue);
    }
}
