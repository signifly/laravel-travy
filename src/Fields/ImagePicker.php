<?php

namespace Signifly\Travy\Fields;

class ImagePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image-picker';

    public function options(array $options)
    {
        return $this->withMeta(['options' => $options]);
    }

    public function url(string $key)
    {
        return $this->withMeta(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['id' => $this->attribute]);
    }
}
