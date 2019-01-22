<?php

namespace Signifly\Travy\Fields;

use Closure;
use JsonSerializable;
use Illuminate\Support\Str;
use Signifly\Travy\Schema\Endpoint;

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
     * @var \Signifly\Travy\Schema\Endpoint
     */
    public $endpoint;

    /**
     * The fields in the tab.
     *
     * @var array
     */
    public $fields = [];

    /**
     * The tab type: `fields` or `table`.
     *
     * @var string
     */
    public $type = 'fields';

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
    public function endpoint(string $url, ?Closure $callable = null): self
    {
        $endpoint = new Endpoint($url);

        if (! is_null($callable)) {
            $callable($endpoint);
        }

        $this->endpoint = $endpoint;

        return $this;
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
     * Get the prepared fields.
     *
     * @return array
     */
    public function getPreparedFields(): array
    {
        return collect($this->fields)
            ->map(function ($field) {
                if (! $this->showOnIndex) {
                    $field->hideFromIndex();
                }

                return $field;
            })
            ->toArray();
    }

    /**
     * Check if the tab has an endpoint.
     *
     * @return bool
     */
    public function hasEndpoint(): bool
    {
        return ! empty($this->endpoint);
    }

    /**
     * Set the tab type.
     *
     * @param  string $type
     * @return self
     */
    public function type(string $type): self
    {
        $this->type = $type;

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
            'type' => $this->type,
            'endpoint' => $this->endpoint->toArray(),
            'title' => $this->localize($this->name),
            'fields' => collect($this->fields)->map->jsonSerialize(),
        ];
    }
}
