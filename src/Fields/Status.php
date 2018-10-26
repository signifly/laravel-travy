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
    public $component = 'status';

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
        $fieldType->text($this->attribute);
    }
}
