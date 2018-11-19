<?php

namespace Signifly\Travy\Fields;

use JsonSerializable;
use Illuminate\Support\Str;

class Tab extends FieldElement implements JsonSerializable
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
     * The tab's endpoint settings.
     *
     * @var array
     */
    public $endpoint;

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
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Set the tab's endpoint.
     *
     * @param  string $url
     * @param  array  $params
     * @return self
     */
    public function endpoint(string $url, array $params = [])
    {
        $this->endpoint = compact('url', 'params');

        return $this;
    }

    /**
     * Check if the tab has an endpoint.
     *
     * @return bool
     */
    public function hasEndpoint() : bool
    {
        return ! empty($this->endpoint);
    }

    /**
     * Set the fields in the tab.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Prepare the sidebar for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->attribute,
            'endpoint' => $this->endpoint,
            'title' => $this->name,
            'fields' => collect($this->fields)->map->jsonSerialize(),
        ];
    }
}
