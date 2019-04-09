<?php

namespace Signifly\Travy\Support;

use Sanitizer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class Input
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
        return collect($this->get($key));
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
}
