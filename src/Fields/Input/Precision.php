<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Precision extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-precision';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = 0;

    public function max(float $value)
    {
        return $this->withProps(['max' => $value]);
    }

    public function precision(int $value)
    {
        return $this->withProps(['precision' => $value]);
    }

    public function step(float $value)
    {
        return $this->withProps(['step' => $value]);
    }

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
