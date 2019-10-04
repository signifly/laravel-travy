<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class ColorPicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-color-picker';

    protected $propsValidationRules = [
        'value' => 'required',
    ];

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['value' => $this->attribute]);
    }
}
