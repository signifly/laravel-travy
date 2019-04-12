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
     * @param Closure|null $callable
     * @return self
     */
    public function endpoint(string $url, ?Closure $callable = null): self
    {
        $endpoint = new Endpoint($url);

        if (! is_null($callable)) {
            $callable($endpoint);
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
