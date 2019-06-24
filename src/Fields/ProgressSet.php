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
     * Set the percentage prop.
     *
     * @param  string $percentage
     * @return self
     */
    public function percentage(string $percentage): self
    {
        return $this->withProps(compact('percentage'));
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
     * Set the title prop.
     *
     * @param  string $title
     * @return self
     */
    public function title(string $title): self
    {
        return $this->withProps(compact('title'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['items' => $this->attribute]);
    }
}
