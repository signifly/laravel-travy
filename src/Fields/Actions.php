<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\Schema\Concerns\HasActions;

class Actions extends Field
{
    use HasActions;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-actions';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['actions' => $this->preparedActions()]);
    }
}
