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

    public function color(string $status)
    {
        return $this->withProps(compact('status'));
    }

    public function size(string $size)
    {
        return $this->withProps(compact('size'));
    }

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
