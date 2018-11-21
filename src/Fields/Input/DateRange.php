<?php

namespace Signifly\Travy\Fields\Input;

class DateRange extends Field
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
        return $this->withMeta(['dateEnd' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['dateStart' => $this->attribute]);
    }
}
