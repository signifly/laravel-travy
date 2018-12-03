<?php

namespace Signifly\Travy\Fields;

class Date extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'date';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['timestamp' => $this->attribute]);
    }
}
