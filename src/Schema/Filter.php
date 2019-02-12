<?php

namespace Signifly\Travy\Schema;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\FieldTypes\FieldTypeFactory;

class Filter implements Arrayable
{
    /**
     * The data for the filter.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The field type to use on the client-side.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * The filter label.
     *
     * @var string
     */
    protected $label;

    /**
     * The filter name.
     *
     * @var string
     */
    protected $name;

    public function __construct($name, $label)
    {
        $this->name($name);
        $this->label($label);
    }

    public function data()
    {
        return $this->data;
    }

    public function fieldType($class, Closure $callable)
    {
        $fieldType = (new FieldTypeFactory($class))->make();

        $callable($fieldType);

        $this->fieldType = $fieldType;

        return $this;
    }

    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Tap into the field type.
     *
     * @param Closure $callable
     *
     * @return void
     */
    public function tapFieldType(Closure $callable)
    {
        $callable($this->fieldType);
    }

    public function withData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function toArray()
    {
        return [
            'name'      => $this->name,
            'label'     => $this->label,
            'fieldType' => $this->fieldType->build(),
        ];
    }
}
