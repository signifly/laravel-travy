<?php

namespace Signifly\Travy\Concerns;

trait HasProps
{
    /**
     * The properties.
     *
     * @var array
     */
    protected $props = [];

    /**
     * Add a new prop.
     *
     * @param string $key
     * @param mixed $value
     */
    public function addProp(string $key, $value)
    {
        $this->props[$key] = $value;

        return $this;
    }

    /**
     * Get a prop for a given key.
     *
     * @param  string $key
     * @return mixed
     */
    public function getProp(string $key)
    {
        return $this->props[$key];
    }

    /**
     * Get the props.
     *
     * @return array
     */
    public function getProps()
    {
        return $this->props;
    }

    /**
     * Determine if a prop with the given key exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasProp(string $key)
    {
        return array_key_exists($key, $this->props);
    }

    /**
     * Determines if there are any props.
     *
     * @return bool
     */
    public function hasProps()
    {
        return count($this->props) > 0;
    }
}
