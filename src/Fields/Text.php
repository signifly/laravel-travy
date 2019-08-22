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
     * Set the align prop.
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
     * Set the bold prop.
     *
     * @param  bool $value
     * @return self
     */
    public function bold($value = true): self
    {
        return $this->withProps(['bold' => $value]);
    }

    /**
     * Set the status prop.
     *
     * @param  string $status
     * @return self
     */
    public function color(string $status): self
    {
        return $this->withProps(compact('status'));
    }

    /**
     * Set the textDefault prop.
     *
     * @param  mixed $text
     * @return self
     */
    public function default($text): self
    {
        return $this->withProps(['textDefault' => $text]);
    }

    /**
     * Set the subtitle prop.
     *
     * @param  string $subtitle
     * @return self
     */
    public function subtitle(string $subtitle): self
    {
        return $this->withProps(compact('subtitle'));
    }

    /**
     * Set the tooltip prop.
     *
     * @param  string $tooltip
     * @return self
     */
    public function tooltip(string $tooltip): self
    {
        return $this->withProps(compact('tooltip'));
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
    public function applyOptions(): void
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
