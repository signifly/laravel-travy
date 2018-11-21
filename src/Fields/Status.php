<?php

namespace Signifly\Travy\Fields;

class Status extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'status';

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
        $this->withProps(['text' => $this->attribute]);
    }
}
