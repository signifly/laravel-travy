<?php

namespace Signifly\Travy\Fields;

class Divider extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'divider';

    public function text(string $text)
    {
        return $this->withProps(['text' => $text]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
    }
}
