<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Signifly\Travy\Support\Input;
use Illuminate\Foundation\Bus\Dispatchable;
use Signifly\Responder\Concerns\Respondable;
use Illuminate\Contracts\Support\Responsable;

abstract class Action
{
    use Dispatchable;
    use Respondable;

    /** @var \Signifly\Travy\Support\Input */
    protected $input;

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
        $this->input = Input::make($request, $this->inputFilters());
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

    /**
     * Sync relations for the resource.
     *
     * @return void
     */
    protected function syncRelations(): void
    {
        $this->resource->getRelations()
            ->onlyBelongsToMany()
            ->each(function ($relation, $relationName) {
                $relationInputKey = Str::snake($relationName);

                if (! $this->input->has($relationInputKey)) {
                    return;
                }

                $relationKeys = $this->input
                    ->collect($relationInputKey)
                    ->pluck($relation->getRelatedKeyName());

                $relation->sync($relationKeys);
            });
    }

    /**
     * The sanitize filters to use on the input.
     *
     * @return array
     */
    protected function inputFilters(): array
    {
        return $this->resource->getSanitizeFilters();
    }
}
