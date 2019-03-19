<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Support\Responsable;
use Signifly\Travy\Http\Concerns\HandlesApiResponses;

abstract class Action
{
    use Dispatchable;
    use HandlesApiResponses;

    /** @var \Illuminate\Http\Request */
    protected $request;

    /** @var \Signifly\Travy\Resource */
    protected $resource;

    /**
     * Create a new action instance.
     *
     * @param Request $request
     * @param resource  $resource
     */
    public function __construct(Request $request, Resource $resource)
    {
        $this->request = $request;
        $this->resource = $resource;
    }

    /**
     * Handle the action.
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    abstract public function handle(): Responsable;

    /**
     * Check if the request has a resource id.
     *
     * @return bool
     */
    public function hasId(): bool
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
        return $this->request->route()->parameter('resourceId');
    }
}
