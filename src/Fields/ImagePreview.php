<?php

namespace Signifly\Travy\Fields;

class ImagePreview extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['image' => $this->attribute]);
    }
}
