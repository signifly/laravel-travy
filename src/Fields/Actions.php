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
     * Set the status prop.
     *
     * @param  string $status
     * @return self
     */
    public function color(string $status): self
    {
        return $this->withProps(compact('status'));
    }

    /**
     * Set the size prop.
     *
     * @param  string $size
     * @return self
     */
    public function size(string $size): self
    {
        return $this->withProps(compact('size'));
    }

    /**
     * Set the title prop.
     *
     * @param  string $title
     * @return self
     */
    public function title(string $title): self
    {
        return $this->withProps(['title' => __($title)]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['actions' => $this->preparedActions()]);
    }
}
