<?php

namespace Signifly\Travy\Schema\Concerns;

use Signifly\Travy\Schema\Field;

trait HasFields
{
    /**
     * The fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Add a new field.
     *
     * @param string $name
     * @param string $label
     */
    public function addField(string $name, string $label)
    {
        $field = new Field($name, $label);

        $this->fields[] = $field;

        return $field;
    }

    /**
     * Add an instance of a field.
     *
     * @param Field $field
     */
    public function addFieldInstance(Field $field)
    {
        array_push($this->fields, $field);

        return $field;
    }

    /**
     * Determine if it contains any fields.
     *
     * @return bool
     */
    public function hasFields()
    {
        return count($this->fields) > 0;
    }

    /**
     * Return an array of prepared fields.
     *
     * @return array
     */
    public function preparedFields()
    {
        return collect($this->fields)->map->toArray();
    }
}
