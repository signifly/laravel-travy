<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Checkbox extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-checkbox';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['value' => $this->attribute]);
    }
}
