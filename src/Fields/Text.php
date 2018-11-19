<?php

namespace Signifly\Travy\Fields;

class Text extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text';

    /**
     * Indicates if the field should be linkable.
     *
     * @var bool
     */
    public $linkable = true;

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        if ($this->component == 'text') {
            $this->withMeta(['text' => $this->attribute]);
        }

        if (in_array($this->component, ['input-text', 'input-number'])) {
            $this->withMeta(['value' => $this->attribute]);
        }
    }
}
