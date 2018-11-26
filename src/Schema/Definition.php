<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Schema\Concerns\HasActions;
use Signifly\Travy\Schema\Contracts\DefinitionContract;

abstract class Definition implements DefinitionContract
{
    use HasActions;

    /**
     * The endpoint array.
     *
     * @var array
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
     */
    public function addIncludes(...$includes)
    {
        $this->includes = $includes;
    }

    /**
     * Set the endpoint for the definition.
     *
     * @param  string $url
     * @param  array  $params
     * @param  string $method
     * @return self
     */
    public function endpoint($url, array $params = [], $method = 'get')
    {
        $this->endpoint = compact('url', 'method', 'params');

        return $this;
    }

    /**
     * Get the resource key.
     *
     * @return string
     */
    public function getResourceKey()
    {
        return $this->request->resourceKey();
    }

    /**
     * Determine if there are any includes.
     *
     * @return bool
     */
    public function hasIncludes()
    {
        return count($this->includes) > 0;
    }

    public function hasModifiers()
    {
        return count($this->modifiers) > 0;
    }

    public function modifiersFromResource()
    {
        $fields = collect($this->request->resource()->modifiers());

        if ($fields->isEmpty()) {
            return;
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
