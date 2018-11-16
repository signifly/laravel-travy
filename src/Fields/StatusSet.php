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
        return $this->withMeta(['title' => $key]);
    }

    public function text(string $key)
    {
        return $this->withMeta(['text' => $key]);
    }

    public function color(string $key)
    {
        return $this->withMeta(['status' => $key]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withMeta(['items' => $this->attribute]);
    }
}
