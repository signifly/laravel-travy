<?php

namespace Signifly\Travy\Fields;

class Checkbox extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'checkbox';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['value' => $this->attribute]);
    }
}
