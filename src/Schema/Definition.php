<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Concerns\HasActions;
use Signifly\Travy\Concerns\HasModifiers;
use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Contracts\DefinitionContract;

abstract class Definition implements DefinitionContract
{
    use HasActions;
    use HasModifiers;

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
     * @param  string $method
     * @return self
     */
    public function endpoint($url, $method = 'get')
    {
        $this->endpoint = compact('url', 'method');

        return $this;
    }

    /**
     * Get the resource key.
     *
     * @return string
     */
    public function getResourceKey()
    {
        return $this->request->route()->parameter('resource');
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

    abstract protected function schema();
}
