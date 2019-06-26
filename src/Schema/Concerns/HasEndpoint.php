<?php

namespace Signifly\Travy\Schema\Concerns;

use Closure;
use Signifly\Travy\Schema\Endpoint;

trait HasEndpoint
{
    /** @var \Signifly\Travy\Schema\Endpoint */
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
