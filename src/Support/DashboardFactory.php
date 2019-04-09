<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Str;
use Signifly\Travy\Exceptions\InvalidDefinitionException;

class DashboardFactory extends Factory
{
    /** @var string */
    protected $class;

    /** @var string */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
        $this->prepareClass();
    }

    /**
     * Create the dashboard.
     *
     * @return \Signifly\Travy\Contracts\Dashboard
     */
    public function create()
    {
        $this->guardAgainstInvalidName();

        return new $this->class;
    }

    /**
     * Prepare the class from the name.
     *
     * @return void
     */
    protected function prepareClass(): void
    {
        $namespace = config('travy.definitions.namespace');
        $name = Str::studly($this->name);
        $this->class = "{$namespace}\\Dashboard\\{$name}Dashboard";
    }

    /**
     * Guard against invalid name.
     *
     * @return void
     */
    protected function guardAgainstInvalidName(): void
    {
        throw_unless(class_exists($this->class), InvalidDefinitionException::class);
    }
}
