<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class InputImage extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'inputImage';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function url(string $key)
    {
        return $this->withMeta(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->file($this->attribute);
    }
}
