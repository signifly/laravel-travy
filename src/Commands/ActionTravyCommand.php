<?php

namespace Signifly\Travy\Commands;

use Illuminate\Console\GeneratorCommand;

class ResourceTravyCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'travy:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Travy Action class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Action';

    /**
     * Get the default namespace for the class.
     *
     * @param  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return config('travy.actions.namespace');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/action.stub';
    }
}
