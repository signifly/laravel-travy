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
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['items' => $this->attribute]);
    }

    public function itemKey(string $key)
    {
        return $this->withMeta(['itemKey' => $key]);
    }

    public function itemLink(string $link)
    {
        return $this->withMeta(['itemLink' => $link]);
    }
}
