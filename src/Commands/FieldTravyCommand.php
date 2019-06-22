<?php

namespace Signifly\Travy\Commands;

use Illuminate\Console\GeneratorCommand;

class FieldTravyCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'travy:field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Travy Field class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Field';

    /**
     * Get the default namespace for the class.
     *
     * @param  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return config('travy.fields.namespace');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/field.stub';
    }
}
