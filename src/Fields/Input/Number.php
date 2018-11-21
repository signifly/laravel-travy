<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Number extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-number';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = 0;

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
