<?php

namespace Signifly\Travy\Fields;

class Status extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'status';

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
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['text' => $this->attribute]);
    }
}
