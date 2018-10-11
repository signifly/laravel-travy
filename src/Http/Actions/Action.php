<?php

namespace Signifly\Travy\Http\Actions;

use Signifly\Travy\Resource;
use Illuminate\Http\Request;
use Signifly\Travy\Support\ResourceFactory;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class Action
{
    use Dispatchable;

    /** @var \Illuminate\Http\Request */
    protected $request;

    /** @var \Signifly\Travy\Resource */
    protected $resource;

    /**
     * Create a new action instance.
     *
     * @param Request $request
     * @param Resource  $resource
     */
    public function __construct(Request $request, Resource $resource)
    {
        $this->request = $request;
        $this->resource = $resource;
    }

    /**
     * The action logic.
     *
     * @return mixed
     */
    abstract public function handle();

    /**
     * Check if the request has a resource id.
     *
     * @return bool
     */
    public function hasId()
    {
        return (bool) $this->request->route()->hasParameter('resourceId');
    }

    /**
     * Retrieve the resource id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->request->resourceId();
    }
}
