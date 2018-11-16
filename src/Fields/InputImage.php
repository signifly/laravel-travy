<?php

namespace Signifly\Travy\Fields;

class InputImage extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-image';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

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
        $this->withMeta(['file' => $this->attribute]);
    }
}
