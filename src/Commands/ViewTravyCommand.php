<?php

namespace Signifly\Travy\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class ViewTravyCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'travy:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Table class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Table';

    /**
     * Get the default namespace for the class.
     *
     * @param  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = config('travy.definitions.namespace');

        return "{$namespace}\\Table";
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/table.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return Str::finish(parent::getNameInput(), 'Table');
    }
}
