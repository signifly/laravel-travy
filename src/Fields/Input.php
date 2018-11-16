<?php

namespace Signifly\Travy\Fields;

class Input extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input';

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
