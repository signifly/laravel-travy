<?php

namespace Signifly\Travy\Schema\Concerns;

use Illuminate\Support\Arr;
use Signifly\Travy\Support\ScopesApplier;

trait HasScopes
{
    /**
     * The scopes for the element.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Forget a given scope.
     *
     * @param  string|array $key
     * @return void
     */
    public function forgetScope($key)
    {
        return Arr::forget($this->scopes, $key);
    }

    /**
     * Get a specific scope.
     *
     * @param  string $key
     * @return mixed
     */
    public function getScope(string $key)
    {
        return Arr::get($this->scopes, $key);
    }

    /**
     * Check if a given scope exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasScope(string $key)
    {
        return Arr::has($this->scopes, $key);
    }

    /**
     * Get the scopes for the element.
     *
     * @return array
     */
    public function scopes()
    {
        return $this->scopes;
    }

    /**
     * Set the scope by key and value.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setScope(string $key, $value): self
    {
        Arr::set($this->scopes, $key, $value);

        return $this;
    }

    /**
     * Set additional scopes for the element.
     *
     * @param  array  $scopes
     * @return $this
     */
    public function withScopes(array $scopes): self
    {
        $this->scopes = array_merge($this->scopes, $scopes);

        return $this;
    }
}
