<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Str;
use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Schema\DefaultTableDefinition;
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
        $this->request = $request;
    }

    /**
     * Create the definition by a given type and entity.
     *
     * @return \Signifly\Travy\Schema\Contracts\DefinitionContract
     */
    public function make()
    {
        $namespace = config('travy.definitions.namespace');
        $type = Str::studly($this->request->route()->parameter('type'));
        $resource = Str::studly($this->request->resourceKey());
        $class = "{$namespace}\\{$type}\\{$resource}{$type}Definition";

        if (class_exists($class)) {
            return new $class($this->request);
        }

        return new DefaultTableDefinition($this->request);
    }
}
