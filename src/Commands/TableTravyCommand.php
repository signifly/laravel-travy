<?php

namespace Signifly\Travy\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class TableTravyCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'travy:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new View class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Get the default namespace for the class.
     *
     * @param  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = config('travy.definitions.namespace');

        return "{$namespace}\\View";
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/view.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return Str::finish(parent::getNameInput(), 'View');
    }
}
