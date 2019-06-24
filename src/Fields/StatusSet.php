<?php

namespace Signifly\Travy\Fields;

class StatusSet extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'status-set';

    /**
     * Set the status prop (alias for status).
     *
     * @param  string $key
     * @return self
     */
    public function color(string $key): self
    {
        return $this->status($key);
    }

    /**
     * Set the status prop.
     *
     * @param  string $key
     * @return self
     */
    public function status(string $key): self
    {
        return $this->withProps(['status' => $key]);
    }

    /**
     * Set the text prop.
     *
     * @param  string $key
     * @return self
     */
    public function text(string $key): self
    {
        return $this->withProps(['text' => $key]);
    }

    /**
     * Set the title prop.
     *
     * @param  string $key
     * @return self
     */
    public function title(string $key): self
    {
        return $this->withProps(['title' => $key]);
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
