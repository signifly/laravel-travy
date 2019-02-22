<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Fields\Field;

class Column
{
    /**
     * The field.
     *
     * @var string
     */
    protected $field;

    /**
     * The order of the column.
     *
     * @var int
     */
    protected $order;

    /**
     * Create a new column instance.
     *
     * @param string $name
     * @param string $label
     */
    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    /**
     * Create a new column.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
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
     * Set width from field.
     *
     * @return self
     */
    public function setWidth(): self
    {
        // Set the width
        if ($width = optional($this->field->width)->getOnIndex()) {
            $this->field->withMeta(['width' => $width]);
        }

        return $this;
    }

    /**
     * Prepare the column for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        if (method_exists($this->field, 'applyOptions')) {
            $this->field->applyOptions();
        }

        return array_merge([
            'order' => $this->order,
            'sortable' => $this->field->sortable,
            'sortBy' => $this->field->sortBy ?? null,
        ], $this->field->jsonSerialize());
    }
}
