<?php

namespace Signifly\Travy\Support;

use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Elegant\Sanitizer\Sanitizer;


class Input implements ArrayAccess, Arrayable
{
    /** @var array */
    protected $data;

    /** @var array */
    protected $filters;

    /** @var array */
    protected $sanitized;

    /**
     * Create a new Input instance.
     *
     * @param array $data
     * @param array $filters
     */
    public function __construct(array $data, array $filters)
    {
        $this->data = $data;
        $this->filters = $filters;
        $this->sanitized = $this->sanitizeInput($data, $filters);
    }

    /**
     * Static method to instantiate input from a request.
     *
     * @param  Request $request
     * @return static
     */
    public static function make(Request $request, array $filters = [])
    {
        $data = data_get($request->all(), 'data', []);

        return new static($data, $filters);
    }

    /**
     * Get all input.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->sanitized;
    }

    /**
     * Get raw input data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Get a given key as a collection.
     *
     * @param  string $key
     * @return \Illuminate\Support\Collection
     */
    public function collect(string $key, $default = null)
    {
        return new Collection($this->get($key));
    }

    /**
     * Get all of the sanitized input except for a specified array of keys.
     *
     * @param  array|string  $keys
     * @return array
     */
    public function except($keys): array
    {
        return Arr::except($this->sanitized, $keys);
    }

    /**
     * Determine if the input contains a non-empty value for an input item.
     *
     * @param  string|array  $key
     * @return bool
     */
    public function filled($key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $value) {
            if ($this->isEmptyString($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get an item from the sanitized input using "dot" notation.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->sanitized, $key, $default);
    }

    /**
     * Check if an item exists.
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return Arr::has($this->sanitized, $key);
    }

    /**
     * Get a specific set of items by the given keys.
     *
     * @param  array|string $keys
     * @return array
     */
    public function only($keys): array
    {
        return Arr::only($this->sanitized, $keys);
    }

    /**
     * Determine if the given input key is an empty string for "has".
     *
     * @param  string  $key
     * @return bool
     */
    protected function isEmptyString($key): bool
    {
        $value = $this->get($key);

        return ! is_bool($value) && ! is_array($value) && trim((string) $value) === '';
    }

    /**
     * Sanitize the input.
     *
     * @param  array  $data
     * @param  array  $filters
     * @return array
     */
    protected function sanitizeInput(array $data, array $filters): array
    {
        $filters = Arr::only($filters, array_keys($data));

        return Sanitizer::make($data, $filters)->sanitize();
    }

    /**
     * Convert the input instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->sanitized[$offset]);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  string  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string  $offset
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->sanitized[$offset] = $value;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->sanitized[$offset]);
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Dynamically unset an attribute.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }
}
