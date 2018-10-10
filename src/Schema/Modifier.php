<?php

namespace Signifly\Travy\Schema;

use Illuminate\Contracts\Support\Arrayable;

class Modifier implements Arrayable
{
    /**
     * The modifier param key.
     *
     * @var string
     */
    protected $key;

    /**
     * The modifier options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The modifier title.
     *
     * @var string
     */
    protected $title;

    /**
     * The modifier value.
     *
     * @var string
     */
    protected $value;

    public function __construct($key, $title)
    {
        $this->key($key);
        $this->title($title);
    }

    public function default($value)
    {
        return $this->value($value);
    }

    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    public function options($options)
    {
        $this->options = $options;

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function toArray()
    {
        $keys = collect(['key', 'title', 'value', 'options']);

        return $keys->mapWithKeys(function ($key) {
            return [$key => $this->$key];
        })->all();
    }
}
