<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Upload extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-upload';

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

    /**
     * Set the fileTypes prop.
     *
     * @param  string $value
     * @return self
     */
    public function fileTypes(string $value): self
    {
        return $this->withProps(['fileTypes' => $value]);
    }

    /**
     * Set the note prop.
     *
     * @param  string $value
     * @return self
     */
    public function note(string $value): self
    {
        return $this->withProps(['note' => $value]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['files' => $this->attribute]);
    }
}
