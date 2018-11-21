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

    public function fileTypes(string $key)
    {
        return $this->withProps(['fileTypes' => $key]);
    }

    public function note(string $key)
    {
        return $this->withProps(['note' => $key]);
    }

    public function url(string $key)
    {
        return $this->withProps(['url' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['file' => $this->attribute]);
    }
}
