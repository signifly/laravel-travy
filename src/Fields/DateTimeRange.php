<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\FieldTypes\FieldType;

class DateTimeRange extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'dateTimeRange';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function end(string $key)
    {
        return $this->withMeta(['end' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @param  FieldType $fieldType
     * @return void
     */
    public function applyOptions(FieldType $fieldType)
    {
        $fieldType->start($this->attribute);
    }
}
