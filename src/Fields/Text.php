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
     * Use as input.
     *
     * @return self
     */
    public function asInput()
    {
        $this->component = 'input-text';

        return $this;
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        if ($this->component == 'text') {
            $this->withProps(['text' => $this->attribute]);
        }

        if (in_array($this->component, ['input-text', 'input-number'])) {
            $this->withProps(['value' => $this->attribute]);
        }
    }
}
