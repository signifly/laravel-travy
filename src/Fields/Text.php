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
     * Align the text.
     *
     * @param  string $align
     * @return self
     */
    public function align(string $align): self
    {
        return $this->withProps(compact('align'));
    }

    /**
     * Use as input.
     *
     * @return self
     */
    public function asInput(): self
    {
        $this->component = 'input-text';

        return $this;
    }

    /**
     * Set the type prop.
     *
     * @param  string $type
     * @return self
     */
    public function type(string $type): self
    {
        return $this->withProps(compact('type'));
    }

    /**
     * Set the unit prop.
     *
     * @param  string $unit
     * @return self
     */
    public function unit(string $unit): self
    {
        return $this->withProps(compact('unit'));
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
            $this->forgetProp(['type', 'unit']);
        }

        if (in_array($this->component, ['input-text', 'input-number'])) {
            $this->withProps(['value' => $this->attribute]);
        }
    }
}
