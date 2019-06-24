<?php

namespace Signifly\Travy\Fields;

use JsonSerializable;
use Illuminate\Support\Str;
use Signifly\Travy\Support\FieldCollection;

class Sidebar extends FieldElement implements JsonSerializable
{
    /**
     * The displayable name of the tab.
     *
     * @var string
     */
    public $name;

    /**
     * The attribute / column name of the tab.
     *
     * @var string
     */
    public $attribute;

    /**
     * The fields in the tab.
     *
     * @var array
     */
    public $fields = [];

    /**
     * Create a new tab.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '-', Str::lower($name));
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments): Sidebar
    {
        return new static(...$arguments);
    }

    /**
     * Set the fields in the tab.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Prepare the sidebar for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->attribute,
            'title' => $this->localize($this->name),
            'fields' => FieldCollection::make($this->fields)->prepared(),
        ];
    }
}
