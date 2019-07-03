<?php

namespace Signifly\Travy\Fields;

use Signifly\Travy\Schema\Action;
use Signifly\Travy\Schema\Endpoint;

class ButtonAction extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-action';

    /**
     * The default method to use for the endpoint.
     *
     * @var string
     */
    protected $defaultMethod = 'post';

    /**
     * Set the action of the field.
     *
     * @param  Action $action
     * @return self
     */
    public function action(Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set the color of the button-action.
     *
     * @param  string $status
     * @return self
     */
    public function color(string $status): self
    {
        return $this->withProps(compact('status'));
    }

    /**
     * Set the icon of the button-action.
     *
     * @param  string $icon
     * @return self
     */
    public function icon(string $icon): self
    {
        return $this->withProps(compact('icon'));
    }

    /**
     * Set the size of the button-action.
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
        $action = $this->action->jsonSerialize();

        $this->withProps([
            'action' => $action['props'],
        ]);
    }
}
