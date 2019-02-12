<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class ImagePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'imagePicker';

    public function options(array $options)
    {
        return $this->withMeta(['options' => $options]);
    }

    public function url(string $key)
    {
        return $this->withMeta(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @param FieldType $fieldType
     *
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->id($this->attribute);
    }
}
