<?php

namespace Signifly\Travy\Fields;

class InputFile extends Field
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

    public function fileTypes(string $key)
    {
        return $this->withMeta(['fileTypes' => $key]);
    }

    public function note(string $key)
    {
        return $this->withMeta(['note' => $key]);
    }

    public function url(string $key)
    {
        return $this->withMeta(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['file' => $this->attribute]);
    }
}
