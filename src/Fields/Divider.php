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

    /**
     * Set the text prop.
     *
     * @param  string $text
     * @return self
     */
    public function text(string $text): self
    {
        return $this->withProps(['text' => __($text)]);
    }
}
