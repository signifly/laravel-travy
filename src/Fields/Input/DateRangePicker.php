<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class DateRangePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-date-range';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function end(string $key)
    {
        return $this->withProps(['dateEnd' => $key]);
    }

    public function format(string $value)
    {
        return $this->withProps(['format' => $value]);
    }

    public function formatValue(string $value)
    {
        return $this->withProps(['formatValue' => $value]);
    }

    public function type(string $type)
    {
        return $this->withProps(compact('type'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['dateStart' => $this->attribute]);
    }
}