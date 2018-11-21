<?php

namespace Signifly\Travy\Fields;

class DateTime extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'date-time';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['epoch' => $this->attribute]);
    }
}
