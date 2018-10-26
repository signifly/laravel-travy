<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class Status extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'statusSet';

    public function title(string $key)
    {
        return $this->withMeta(['title' => $key]);
    }

    public function text(string $key)
    {
        return $this->withMeta(['text' => $key]);
    }

    public function color(string $key)
    {
        return $this->withMeta(['status' => $key]);
    }

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
}
