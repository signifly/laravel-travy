<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Toggle extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-switch';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = false;

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
