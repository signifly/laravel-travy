<?php

namespace Signifly\Travy\Fields;

use JsonSerializable;
use Illuminate\Support\Str;
use Signifly\Travy\Support\FieldCollection;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Tab extends FieldElement implements JsonSerializable
{
    use HasEndpoint;

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
     * The tab type: `fields` or `table`.
     *
     * @var string
     */
    public $type = 'fields';

    /**
     * The url it should link to.
     *
     * @var string
     */
    public $url = null;

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
    public static function make(...$arguments): Tab
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

                if (! $this->showOnCreation) {
                    $field->hideWhenCreating();
                }

                if (! $this->showOnUpdate) {
                    $field->hideWhenUpdating();
                }

                return $field;
            })
            ->toArray();
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
     * Set the tab url.
     *
     * @param  string $url
     * @return self
     */
    public function url(string $url): self
    {
        $this->url = $url;

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
            'type' => $this->type,
            'endpoint' => $this->endpoint->toArray(),
            'title' => ['text' => $this->localize($this->name), 'url' => $this->url],
            'fields' => FieldCollection::make($this->fields)->prepared(),
        ];
    }
}
