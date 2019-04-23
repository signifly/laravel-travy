<?php

namespace Signifly\Travy\Fields;

class TimeSince extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'time-since';

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
