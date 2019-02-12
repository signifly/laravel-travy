<?php

namespace Signifly\Travy\FieldTypes;

use Illuminate\Support\Str;

class FieldTypeFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new FieldType.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Make the FieldType instance.
     *
     * @return \Signifly\Travy\FieldTypes\FieldType
     */
    public function make()
    {
        if (Str::contains($this->name, 'FieldType') && class_exists($this->name)) {
            return new $this->name();
        }

        $class = __NAMESPACE__.'\\'.Str::studly($this->name).'FieldType';

        return new $class();
    }
}
