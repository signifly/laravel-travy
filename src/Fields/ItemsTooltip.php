<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

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
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->items($this->attribute);
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
