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

    /**
     * Set the options prop.
     *
     * @param  array  $options
     * @return self
     */
    public function options(array $options): self
    {
        return $this->withProps(['options' => $options]);
    }

    /**
     * Set the url prop.
     *
     * @param  string $key
     * @return self
     */
    public function url(string $key): self
    {
        return $this->withProps(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['id' => $this->attribute]);
    }
}
