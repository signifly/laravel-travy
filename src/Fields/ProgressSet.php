<?php

namespace Signifly\Travy\Fields;

class ProgressSet extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'progress-set';

    public function color(string $key)
    {
        return $this->withProps(['status' => $key]);
    }

    public function items(string $items)
    {
        return $this->withProps(compact('items'));
    }

    public function title(string $title)
    {
        return $this->withProps(compact('title'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['percentage' => $this->attribute]);
    }
}
