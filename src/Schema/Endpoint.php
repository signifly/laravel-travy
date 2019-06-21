<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;

class Endpoint implements Arrayable
{
    /** @var array */
    protected $payload = [];

    /** @var array */
    protected $params = [];

    /** @var string */
    protected $method;

    /** @var string */
    protected $url;

    /**
     * Create a new Endpoint class from a url.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Add a filter to the endpoint.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function addFilter(string $key, $value): self
    {
        return $this->addParam("filter.{$key}", $value);
    }

    /**
     * Add a param to the endpoint.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function addParam(string $key, $value): self
    {
        Arr::set($this->params, $key, $value);

        return $this;
    }

    /**
     * Add sort param to the endpoint.
     *
     * @param  string $value
     * @return self
     */
    public function addSort(string $value): self
    {
        return $this->addParam('sort', $value);
    }

    /**
     * Check if the endpoint has any params.
     *
     * @return bool
     */
    public function hasParams(): bool
    {
        return count($this->params) > 0;
    }

    /**
     * Set the additional payload.
     *
     * @param  array  $payload
     * @return self
     */
    public function payload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set the method for the endpoint.
     *
     * @param  string $method
     * @return self
     */
    public function usingMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Convert endpoint to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'url' => $this->url,
        ];

        if ($this->hasParams()) {
            Arr::set($data, 'params', $this->params);
        }

        if ($this->method) {
            Arr::set($data, 'method', $this->method);
        }

        if (count($this->payload) > 0) {
            Arr::set($data, 'payload', $this->payload);
        }

        return $data;
    }
}
