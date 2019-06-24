<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Editor extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-editor-markdown';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['content' => $this->attribute]);
    }
}
