<?php

namespace Signifly\Travy\Fields;

class Progress extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'progress';

    public function color(string $key)
    {
        return $this->withProps(['status' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['percentage' => $this->attribute]);
    }
}
