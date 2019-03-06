<?php

namespace Signifly\Travy\Fields;

class RadioGroup extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'radio-group';

    /**
     * Set the items.
     *
     * @param  array  $items
     * @return self
     */
    public function items(array $items): self
    {
        return $this->withProps(['items' => $items]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['value' => $this->attribute]);
    }
}
