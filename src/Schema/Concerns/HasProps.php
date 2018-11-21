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
