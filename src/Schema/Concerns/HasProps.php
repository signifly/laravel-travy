<?php

namespace Signifly\Travy\Schema\Concerns;

trait HasProps
{
    /**
     * The props for the element.
     *
     * @var array
     */
    public $props = [];

    /**
     * Forget a given prop.
     *
     * @param  string $key
     * @return void
     */
    public function forgetProp(string $key)
    {
        return array_forget($this->props, $key);
    }

    /**
     * Get a specific prop.
     *
     * @param  string $key
     * @return mixed
     */
    public function getProp(string $key)
    {
        return array_get($this->props, $key);
    }

    /**
     * Check if a given prop exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasProp(string $key)
    {
        return array_has($this->props, $key);
    }

    /**
     * Get the props for the element.
     *
     * @return array
     */
    public function props()
    {
        return $this->props;
    }

    /**
     * Set additional props for the element.
     *
     * @param  array  $props
     * @return $this
     */
    public function withProps(array $props)
    {
        $this->props = array_merge($this->props, $props);

        return $this;
    }
}
