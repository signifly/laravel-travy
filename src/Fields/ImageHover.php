<?php

namespace Signifly\Travy\Fields;

class ImageHover extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image-hover';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['image' => $this->attribute]);
    }
}
