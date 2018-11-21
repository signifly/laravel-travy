<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class ImagePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-image-picker';

    public function options(array $options)
    {
        return $this->withProps(['options' => $options]);
    }

    public function url(string $key)
    {
        return $this->withProps(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['id' => $this->attribute]);
    }
}
