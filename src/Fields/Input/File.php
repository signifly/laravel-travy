<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class File extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-file';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Set the fileTypes prop.
     *
     * @param  string $key
     * @return self
     */
    public function fileTypes(string $key): self
    {
        return $this->withProps(['fileTypes' => $key]);
    }

    /**
     * Set the note prop.
     *
     * @param  string $key
     * @return self
     */
    public function note(string $key): self
    {
        return $this->withProps(['note' => $key]);
    }

    /**
     * Set the url prop.
     *
     * @param  string $key
     * @return self
     */
    public function url(string $key): self
    {
        return $this->withProps(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['file' => $this->attribute]);
    }
}
