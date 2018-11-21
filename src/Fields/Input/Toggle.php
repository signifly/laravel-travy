<?php

namespace Signifly\Travy\Fields\Input;

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
        $this->withMeta(['value' => $this->attribute]);
    }
}
