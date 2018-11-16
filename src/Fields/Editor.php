<?php

namespace Signifly\Travy\Fields;

class Editor extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'editor';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['content' => $this->attribute]);
    }
}
