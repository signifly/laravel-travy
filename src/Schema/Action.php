<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Concerns\HasMetaData;

class Action
{
    use HasMetaData;

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
     * The action's icon.
     *
     * @var string
     */
    public $icon;

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
     * Set the endpoint of the action.
     *
     * @param  string $url
     * @param  string $method
     * @return self
     */
    public function endpoint(string $url, $method = 'post')
    {
        return $this->withMeta(compact('url', 'method'));
    }

    /**
     * Set the fields in the tab.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields)
    {
        $fields = collect($fields)->map(function ($field) {
            return $field->jsonSerialize();
        })
        ->toArray();

        return $this->withMeta(compact('fields'));
    }

    /**
     * Set the action's icon.
     *
     * @param  string $icon
     * @return self
     */
    public function icon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the linksTo on submit.
     *
     * @param  string $linksTo
     * @return self
     */
    public function onSubmit(string $linksTo)
    {
        return $this->withMeta(['onSubmit' => $linksTo]);
    }

    /**
     * Set the payload prop.
     *
     * @param  array  $payload
     * @return self
     */
    public function payload(array $payload)
    {
        return $this->withMeta(compact('payload'));
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

        return $this->withMeta(compact('title'));
    }

    /**
     * Set the action type.
     *
     * @param  string $id
     * @return self
     */
    public function type(string $id)
    {
        return $this->withMeta(compact('id'));
    }

    /**
     * Prepare the action for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'title' => $this->title,
            'props' => $this->meta(),
        ];

        if ($this->status) {
            array_set($data, 'status', $this->status);
        }

        if ($this->icon) {
            array_set($data, 'icon', $this->icon);
        }

        return $data;
    }
}
