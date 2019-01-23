<?php

namespace Signifly\Travy\Schema;

use Closure;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Schema\Concerns\HasActions;
use Signifly\Travy\Schema\Contracts\DefinitionContract;

abstract class Definition implements DefinitionContract
{
    use HasActions;

    /**
     * The endpoint instance.
     *
     * @var \Signifly\Travy\Schema\Endpoint
     */
    protected $endpoint;

    /**
     * The includes for the definition schema.
     *
     * @var array
     */
    protected $includes = [];

    /**
     * The modifiers array.
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new table definition instance.
     *
     * @param \Signifly\Travy\Http\Requests\TravyRequest $request
     */
    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Add includes to the definition schema.
     *
     * @param $includes
     * @return self
     */
    public function addIncludes(...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * Set the endpoint for the definition.
     *
     * @param  string $url
     * @param Clousure|null $callback
     * @return self
     */
    public function endpoint($url, ?Closure $callback = null): self
    {
        $endpoint = new Endpoint($url);

        if (! is_null($callable)) {
            $callable($endpoint);
        }

        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get the resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return $this->request->resourceKey();
    }

    /**
     * Determine if there are any includes.
     *
     * @return bool
     */
    public function hasIncludes(): bool
    {
        return count($this->includes) > 0;
    }

    public function hasModifiers(): bool
    {
        return count($this->modifiers) > 0;
    }

    public function modifiersFromResource(): self
    {
        $fields = collect($this->request->resource()->modifiers());

        if ($fields->isEmpty()) {
            return $this;
        }

        // Prepare data
        $data = $fields->mapWithKeys(function ($field) {
                return [$field->attribute => $field->defaultValue ?? ''];
            })
            ->toArray();

        // Prepare fields
        $fields = $fields->map(function ($field) {
                $field->linkable(false);
                return $field->jsonSerialize();
            })
            ->toArray();

        $this->modifiers = compact('data', 'fields');

        return $this;
    }

    abstract protected function schema();
}
