<?php

namespace Signifly\Travy\Fields;

class Upload extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'upload';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = [];

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function fileTypes(string $value)
    {
        return $this->withMeta(['fileTypes' => $value]);
    }

    public function note(string $value)
    {
        return $this->withMeta(['note' => $value]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['files' => $this->attribute]);
    }
}