<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class DatePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-date';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function format(string $value)
    {
        return $this->withProps(['format' => $value]);
    }

    public function formatValue(string $value)
    {
        return $this->withProps(['formatValue' => $value]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['date' => $this->attribute]);
    }
}
