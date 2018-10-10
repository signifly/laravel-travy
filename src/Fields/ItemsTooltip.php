<?php

namespace Signifly\Travy\Fields;

class ItemsTooltip extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'itemsTooltip';

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function options(FieldType $fieldType)
    {
        $fieldType->items($this->attribute);
    }

    public function itemKey(string $key)
    {
        $this->withMeta(['itemKey' => $key]);

        return $this;
    }

    public function itemLink(string $link)
    {
        $this->withMeta(['itemLink' => $link]);

        return $this;
    }
}
