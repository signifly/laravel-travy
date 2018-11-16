<?php

namespace Signifly\Travy\Fields;

class DatePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'date-picker';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function format(string $value)
    {
        return $this->withMeta(['format' => $value]);
    }

    public function formatValue(string $value)
    {
        return $this->withMeta(['formatValue' => $value]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['date' => $this->attribute]);
    }
}
