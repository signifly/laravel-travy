<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Str;
use Signifly\Travy\Schema\DefaultView;
use Signifly\Travy\Http\Requests\TravyRequest;

class ViewFactory extends Factory
{
    /** @var string */
    protected $class;

    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
        $this->prepareClass();
    }

    /**
     * Create the dashboard.
     *
     * @return \Signifly\Travy\Contracts\Dashboard
     */
    public function create()
    {
        if (class_exists($this->class)) {
            return new $this->class($this->request);
        }

        return new DefaultView($this->request);
    }

    /**
     * Prepare the class from the name.
     *
     * @return void
     */
    protected function prepareClass(): void
    {
        $namespace = config('travy.definitions.namespace');
        $name = Str::studly(Str::singular($this->request->resourceKey()));
        $this->class = "{$namespace}\\View\\{$name}View";
    }
}