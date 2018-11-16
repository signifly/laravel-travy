<?php

namespace Signifly\Travy\Fields;

class TextBold extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text-bold';

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
        if ($this->component == 'text-bold') {
            $this->withMeta(['text' => $this->attribute]);
        }

        if (in_array($this->component, ['input', 'input-number'])) {
            $this->withMeta(['value' => $this->attribute]);
        }
    }
}
