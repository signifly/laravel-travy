<?php

namespace Signifly\Travy\Schema\Concerns;

use Illuminate\Support\Arr;

trait HasMetaData
{
    /**
     * The meta data for the element.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * Forget a given meta key.
     *
     * @param  string $key
     * @return void
     */
    public function forgetMeta(string $key)
    {
        return Arr::forget($this->meta, $key);
    }

    /**
     * Get a specific meta value.
     *
     * @param  string $key
     * @return mixed
     */
    public function getMeta(string $key)
    {
        return Arr::get($this->meta, $key);
    }

    /**
     * Check if a given meta key exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasMeta(string $key)
    {
        return Arr::has($this->meta, $key);
    }

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
