<?php

namespace Signifly\Travy\Fields;

class Divider extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'divider';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function text(string $text)
    {
        return $this->withProps(['text' => $text]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
    }
}
