<?php

namespace Signifly\Travy\Schema\Concerns;

trait HasOptions
{
    /**
     * The options for the element.
     *
     * @var array
     */
    public $options = [];

    /**
     * The default options for the element.
     *
     * @return array
     */
    public function defaultOptions() : array
    {
        return [];
    }

    /**
     * Get the options for the element.
     *
     * @return array
     */
    public function options()
    {
        return array_merge($this->defaultOptions(), $this->options);
    }

    /**
     * Set additional options for the element.
     *
     * @param  array  $options
     * @return $this
     */
    public function withOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }
}
