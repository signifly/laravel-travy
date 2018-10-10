<?php

namespace Signifly\Travy\Schema;

use Closure;
use Signifly\Travy\Concerns\HasProps;
use Signifly\Travy\Concerns\HasFields;
use Illuminate\Contracts\Support\Arrayable;

class Action implements Arrayable
{
    use HasFields;
    use HasProps;

    /**
     * The action endpoint.
     *
     * @var array
     */
    protected $endpoint = [];

    /**
     * Hide the action.
     *
     * @var array
     */
    protected $hide;

    /**
     * The action icon.
     *
     * @var string
     */
    protected $icon;

    /**
     * The action status.
     *
     * @var string
     */
    protected $status;

    /**
     * The action title.
     *
     * @var string
     */
    protected $title;

    /**
     * The action type.
     *
     * @var string
     */
    protected $type;

    public function __construct($title, $status = null)
    {
        $this->title($title);
        $this->status($status);
    }

    public function data(array $data)
    {
        return $this->addProp('data', (object) $data);
    }

    public function endpoint($url, $method = 'post')
    {
        return $this->addProp('endpoint', compact('url', 'method'));
    }

    /**
     * Hide field type.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $operator
     * @return self
     */
    public function hide(string $key, $value, string $operator = 'eq')
    {
        $this->hide = compact('key', 'operator', 'value');

        return $this;
    }

    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;
        $this->addProp('title', $title);

        return $this;
    }

    public function id($id)
    {
        return $this->addProp('id', $id);
    }

    public function onSubmit($submit)
    {
        return $this->addProp('onSubmit', $submit);
    }

    public function type($type)
    {
        return $this->id($type);
    }

    public function toArray()
    {
        if ($this->hasFields()) {
            $this->addProp('fields', $this->preparedFields());
        }

        return collect([
            'title' => $this->title,
            'props' => $this->props,
        ])->when($this->status, function ($collection) {
            return $collection->put('status', $this->status);
        })->when($this->icon, function ($collection) {
            return $collection->put('icon', $this->icon);
        })->when($this->hide, function ($collection) {
            return $collection->put('hide', $this->hide);
        })->all();
    }
}
