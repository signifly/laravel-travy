<?php

namespace Signifly\Travy\Schema;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\FieldTypes\FieldType;
use Signifly\Travy\FieldTypes\FieldTypeFactory;
use Signifly\Travy\Exceptions\InvalidFieldTypeException;

class Field implements Arrayable
{
    /**
     * The associated field type.
     *
     * @var array
     */
    protected $fieldType;

    /**
     * The label of the field.
     *
     * @var string
     */
    protected $label;

    /**
     * The name of the field.
     *
     * @var string
     */
    protected $name;

    /**
     * Whether the field is required.
     *
     * @var boolean
     */
    protected $required = true;

    /**
     * Set a tooltip text.
     *
     * @var string
     */
    protected $tooltip;

    /**
     * Create a new field instance.
     *
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Set the field type.
     *
     * @param  string  $className
     * @param  Closure $callable
     * @return self
     */
    public function fieldType(string $className, Closure $callable)
    {
        $fieldType = (new FieldTypeFactory($className))->make();

        if (! $fieldType instanceof FieldType) {
            throw new InvalidFieldTypeException();
        }

        $callable($fieldType);

        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Set the label property.
     *
     * @param  string $value
     * @return self
     */
    public function label(string $value)
    {
        $this->label = $value;

        return $this;
    }

    /**
     * Set the name property.
     *
     * @param  string $value
     * @return self
     */
    public function name(string $value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * Set the required property.
     *
     * @param  bool   $value
     * @return self
     */
    public function required(bool $value)
    {
        $this->required = $value;

        return $this;
    }

    /**
     * Tap into the field type.
     *
     * @param  Closure $callable
     * @return void
     */
    public function tapFieldType(Closure $callable)
    {
        $callable($this->fieldType);
    }

    /**
     * Return the field as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'name' => $this->name,
            'label' => $this->label,
            'required' => $this->required,
            'fieldType' => $this->fieldType->build(),
        ];

        if ($this->tooltip) {
            $data['tooltip'] = $this->tooltip;
        }

        return $data;
    }
}
