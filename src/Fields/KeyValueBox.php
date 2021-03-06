<?php

namespace Signifly\Travy\Fields;

class KeyValueBox extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'key-value-box';

    /** @var array */
    protected $items = [];

    /**
     * Add a new item.
     *
     * @param string $label
     * @param string $value
     * @return self
     */
    public function addItem(string $label, string $value): self
    {
        array_push($this->items, compact('label', 'value'));

        return $this;
    }

    /**
     * Set the items for the field.
     *
     * @param  array<label, value>  $items
     * @return self
     */
    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['items' => $this->items]);
    }
}
