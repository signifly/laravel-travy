<?php

namespace Signifly\Travy\Support;

use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Exceptions\InvalidDefinitionException;

class DefinitionFactory
{
    /**
     * The request instance.
     *
     * @var \Signifly\Travy\Http\Requests\TravyRequest
     */
    protected $request;

    /**
     * Create a new DefinitionFactory instance.
     *
     * @param \Signifly\Travy\Http\Requests\TravyRequest $request
     */
    public function __construct(TravyRequest $request)
    {
        $this->entity = $entity;
    }

    /**
     * Create the definition by a given type and entity.
     *
     * @return \Signifly\Travy\Contracts\DefinitionContract
     */
    public function make()
    {
        $namespace = "App\\Definitions";
        $type = studly_case($this->request->route()->parameter('type'));
        $resource = studly_case($this->request->route()->parameter('resource'));
        $class = "{$namespace}\\{$type}\\{$resource}{$type}Definition";

        if (! class_exists($class)) {
            throw new InvalidDefinitionException();
        }

        return new $class($this->request);
    }
}
