<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Concerns\HasProps;
use Signifly\Travy\Schema\Concerns\HasActions;
use Signifly\Travy\Schema\Concerns\HasEndpoint;
use Signifly\Travy\Schema\Concerns\HasMetaData;

class Action
{
    use HasProps;
    use HasActions;
    use HasMetaData;
    use HasEndpoint;

    /**
     * The default method to use for the endpoint.
     *
     * @var string
     */
    protected $defaultMethod = 'post';

    /**
     * The displayable title of the action.
     *
     * @var string
     */
    public $title;

    /**
     * The status / color of the action.
     *
     * @var string
     */
    public $status;

    /**
     * Create a new action.
     *
     * @param string $title
     * @param string|null $status
     */
    public function __construct($title, $status = null)
    {
        $this->title($title);
        $this->status = $status;
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Set the fields in the tab.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields)
    {
        $fields = collect($fields)
            ->map(function ($field) {
                $field->linkable(false);

                if ($field->width instanceof Width) {
                    $field->withMeta(['width' => $field->width->getValue()]);
                }

                return $field->jsonSerialize();
            })
            ->toArray();

        return $this->withProps(compact('fields'));
    }

    /**
     * Hide action on given constraint.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $operator
     * @return self
     */
    public function hide(string $key, $value, string $operator = 'eq')
    {
        return $this->withMeta(['hide' => compact('key', 'operator', 'value')]);
    }

    /**
     * Set the action's icon.
     *
     * @param  string $icon
     * @return self
     */
    public function icon(string $icon)
    {
        return $this->withMeta(compact('icon'));
    }

    /**
     * Set the linksTo on submit.
     *
     * @param  string $linksTo
     * @return self
     */
    public function onSubmit(string $linksTo)
    {
        return $this->withProps(['onSubmit' => $linksTo]);
    }

    /**
     * Set the payload prop.
     *
     * @param  array  $payload
     * @return self
     */
    public function payload(array $payload)
    {
        return $this->withProps(compact('payload'));
    }

    /**
     * Set the text prop.
     *
     * @param  string $text
     * @return self
     */
    public function text(string $text)
    {
        return $this->withProps(compact('text'));
    }

    /**
     * Sets the title of the action.
     *
     * @param  string $title
     * @return self
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this->withProps(['title' => __($title)]);
    }

    /**
     * Set the action type.
     *
     * @param  string $id
     * @return self
     */
    public function type(string $id)
    {
        return $this->withProps(compact('id'));
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        if ($this->status) {
            $this->withMeta(['status' => $this->status]);
        }

        if ($this->hasActions()) {
            $this->withProps(['actions' => $this->preparedActions()]);
        }

        if ($this->hasEndpoint()) {
            $this->withProps(['endpoint' => $this->endpoint->toArray()]);
        }

        return array_merge([
            'title' => __($this->title),
            'props' => $this->props(),
        ], $this->meta());
    }
}
