<?php

namespace Signifly\Travy\Schema\Concerns;

trait HasMetaData
{
    /**
     * The meta data for the element.
     *
     * @var array
     */
    public $meta = [];

    /**
     * Get the meta data for the element.
     *
     * @return array
     */
    public function meta()
    {
        return $this->meta;
    }

    /**
     * Set additional meta information for the element.
     *
     * @param  array  $meta
     * @return $this
     */
    public function withMeta(array $meta)
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }
}
