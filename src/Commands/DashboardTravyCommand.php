<?php

namespace Signifly\Travy\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class DashboardTravyCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'travy:dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Dashboard class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Dashboard';

    /**
     * Get the default namespace for the class.
     *
     * @param  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = config('travy.definitions.namespace');

        return "{$namespace}\\Dashboard";
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/dashboard.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return Str::finish(parent::getNameInput(), 'Dashboard');
    }
}
