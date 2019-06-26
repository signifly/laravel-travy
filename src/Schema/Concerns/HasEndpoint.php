<?php

namespace Signifly\Travy\Schema\Concerns;

use Closure;
use Signifly\Travy\Schema\Endpoint;

trait HasEndpoint
{
    /**
     * The endpoint instance.
     *
     * @var \Signifly\Travy\Schema\Endpoint
     */
    protected $endpoint;

    /**
     * Set the endpoint of the button-action.
     *
     * @param  string $url
     * @param string|\Closure|null $method
     * @return self
     */
    public function endpoint(string $url, $method = null): self
    {
        $endpoint = new Endpoint($url);

        // If there is defined a defaultMethod property on the class
        // then we set the method on the endpoint instance
        if (isset($this->defaultMethod)) {
            $endpoint->usingMethod($this->defaultMethod);
        }

        if ($method instanceof Closure) {
            $method($endpoint);
        } elseif (is_string($method)) {
            $endpoint->usingMethod($method);
        }

        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Check if the tab has an endpoint.
     *
     * @return bool
     */
    public function hasEndpoint(): bool
    {
        return ! empty($this->endpoint);
    }
}
