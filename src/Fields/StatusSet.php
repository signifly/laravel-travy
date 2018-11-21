<?php

namespace Signifly\Travy\Fields;

class StatusSet extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'statusSet';

    public function title(string $key)
    {
        return $this->withProps(['title' => $key]);
    }

    public function text(string $key)
    {
        return $this->withProps(['text' => $key]);
    }

    public function color(string $key)
    {
        return $this->withProps(['status' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['items' => $this->attribute]);
    }
}
