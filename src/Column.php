<?php

namespace Signifly\Travy;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\FieldTypes\FieldTypeFactory;

class Column implements Arrayable
{
    /**
     * The field type to use on the client-side.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * The label for table header.
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
     * The order of the column.
     *
     * @var int
     */
    protected $order;

    /**
     * Indicates if the column is sortable.
     *
     * @var boolean
     */
    protected $sortable = false;

    /**
     * The prop to sort by.
     *
     * @var string
     */
    protected $sortBy = null;

    /**
     * The width of the column.
     *
     * @var int
     */
    protected $width;

    /**
     * Create a new column instance.
     *
     * @param string $name
     * @param string $label
     */
    public function __construct($name, $label)
    {
        $this->name($name);
        $this->label($label);
    }

    /**
     * Set the field type.
     *
     * @param  string  $class
     * @param  Closure $callable
     * @return self
     */
    public function fieldType(string $class, Closure $callable)
    {
        $fieldType = (new FieldTypeFactory($class))->make();

        $callable($fieldType);

        $this->fieldType = $fieldType->build();

        return $this;
    }

    /**
     * Set the label property.
     *
     * @param  string $label
     * @return self
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the name property.
     *
     * @param  string $name
     * @return self
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the order property.
     *
     * @param  int $order
     * @return self
     */
    public function order($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Set the sortable field.
     *
     * @param  bool|string $sortable
     * @return self
     */
    public function sortable($sortable = true)
    {
        if ($sortable && ! is_bool($sortable)) {
            $this->sortable = true;
            $this->sortBy = $sortable;

            return $this;
        }

        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Set the column to sort by.
     *
     * @param  string $sortBy
     * @return self
     */
    public function sortBy(string $sortBy)
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * Set the width of the column.
     *
     * @param  int $width
     * @return self
     */
    public function width($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Convert the column to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $keys = collect(['order', 'name', 'label', 'fieldType', 'sortable', 'sortBy']);

        if ($this->width) {
            $keys->push('width');
        }

        return $keys->mapWithKeys(function ($key) {
            return [$key => $this->$key];
        })->all();
    }
}
