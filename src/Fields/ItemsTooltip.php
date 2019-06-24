<?php

namespace Signifly\Travy\Fields;

class ItemsTooltip extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'items-tooltip';

    /**
     * Indicates if the element should be shown on the creation view.
     *
     * @var bool
     */
    public $showOnCreation = false;

    /**
     * Indicates if the element should be shown on the update view.
     *
     * @var bool
     */
    public $showOnUpdate = false;

    /**
     * Set the itemKey prop.
     *
     * @param  string $key
     * @return self
     */
    public function itemKey(string $key): self
    {
        return $this->withProps(['itemKey' => $key]);
    }

    /**
     * Set the itemLink prop.
     *
     * @param  string $link
     * @return self
     */
    public function itemLink(string $link): self
    {
        return $this->withProps(['itemLink' => $link]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['items' => $this->attribute]);
    }
}
