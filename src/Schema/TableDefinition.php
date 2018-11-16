<?php

namespace Signifly\Travy\Schema;

use Closure;
use Illuminate\Support\Str;
use Signifly\Travy\Schema\Column;
use Signifly\Travy\Schema\Concerns\HasColumns;

abstract class TableDefinition extends Definition
{
    use HasColumns;

    /**
     * The batch schema for the definition schema.
     *
     * @var array
     */
    protected $batchSchema;

    /**
     * The endpoint to redirect to on creation.
     * - defaults to /t/{resource}/{id}
     *
     * @var string|null
     */
    protected $creationRedirectTo = null;

    /**
     * The defaults for the definition schema.
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * The filters array.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * The search placeholder.
     *
     * @var string
     */
    protected $searchPlaceholder;

    /**
     * Add default to the definition schema.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function addDefault($key, $value)
    {
        $this->defaults[$key] = $value;

        return $this;
    }

    /**
     * Build the schema.
     *
     * @return array
     */
    public function build() : array
    {
        $this->schema();

        $schema = [
            'columns' => $this->preparedColumns(),
            'endpoint' => $this->endpoint ?? $this->guessEndpoint(),
            'defaults' => $this->defaults,
        ];

        if ($this->hasActions()) {
            array_set($schema, 'actions', $this->preparedActions());
        }

        if ($this->hasFilters()) {
            array_set($schema, 'filters', $this->filters);
        }

        if ($this->hasIncludes()) {
            array_set($schema, 'includes', $this->includes);
        }

        if ($this->hasModifiers()) {
            array_set($schema, 'modifiers', $this->modifiers);
        }

        if ($this->searchPlaceholder) {
            array_set($schema, 'search.placeholder', $this->searchPlaceholder);
        }

        if ($this->batchSchema) {
            array_set($schema, 'batch', $this->batchSchema);
        }

        return $schema;
    }

    /**
     * Build the batch schema.
     *
     * @param  Closure $callable
     * @return void
     */
    public function buildBatch(Closure $callable)
    {
        $this->batchSchema = Batch::build($callable);
    }

    /**
     * Get columns from the resource's fields.
     *
     * @return self
     */
    public function columnsFromResource()
    {
        $fields = $this->request->resource()->getPreparedFields();

        $fields->filter(function ($field) {
            return $field->showOnIndex;
        })->each(function ($field) {
            if ($field->linkable && ! $field->linksTo) {
                $field->linksTo = "/t/{$this->request->resourceKey()}/{id}";
            }
            $column = Column::make($field);
            $this->addColumn($column);
        });

        // Default sorting
        $defaultSort = $fields->first(function ($field) {
            return $field->defaultSort;
        });

        if ($defaultSort) {
            $this->addDefault('sort', [
                'prop' => $defaultSort->sortBy,
                'order' => $defaultSort->defaultSortOrder,
            ]);
        }

        // Search placeholder
        $searchable = $fields->filter(function ($field) {
            return $field->searchable;
        })->implode('name', ', ');

        $this->searchPlaceholder(
            $searchable ? 'Search for ' . $searchable : 'Search...'
        );

        return $this;
    }

    public function createActionFromResource()
    {
        $resource = $this->request->resource();
        $fields = $resource->getPreparedFields();
        $resourceKey = $this->request->resourceKey();
        $resourceName = str_replace('-', ' ', Str::kebab($resource->displayAs()));

        // Only creatable fields
        $creatableFields = $fields->filter(function ($field) {
            return $field->showOnCreation;
        });

        // Prepare payload
        $payload = $creatableFields->mapWithKeys(function ($field) {
            return [$field->attribute => $field->defaultValue ?? ''];
        });

        $action = Action::make("Add {$resourceName}", 'primary')
            ->icon('plus')
            ->type('modal')
            ->endpoint(url("v1/admin/{$resourceKey}"))
            ->onSubmit($this->creationRedirectTo ?? "/t/{$resourceKey}/{id}")
            ->fields($creatableFields->toArray())
            ->payload(['data' => $payload->toArray()]);

        $this->addAction($action);

        return $this;
    }

    /**
     * Get filterable fields from the resource.
     *
     * @return self
     */
    public function filtersFromResource()
    {
        $fields = collect($this->request->resource()->filterableFields());

        if ($fields->isEmpty()) {
            return;
        }

        // Prepare data
        $data = $fields->mapWithKeys(function ($field) {
                return [$field->attribute => $field->defaultValue ?? ''];
            })
            ->toArray();

        // Prepare fields
        $fields = $fields->map(function ($field) {
                return $field->jsonSerialize();
            })
            ->toArray();

        $this->filters = compact('data', 'fields');

        return $this;
    }

    /**
     * Get includes from the resource.
     *
     * @return self
     */
    public function includesFromResource()
    {
        $this->addIncludes(...$this->request->resource()->allowedIncludes());

        return $this;
    }

    /**
     * Load columns, filters and includes from resource.
     *
     * @return self
     */
    public function loadFromResource()
    {
        $this->columnsFromResource();
        $this->filtersFromResource();
        $this->includesFromResource();
        $this->modifiersFromResource();

        return $this;
    }

    public function hasFilters()
    {
        return count($this->filters) > 0;
    }

    /**
     * Try guessing the endpoint.
     *
     * @return string|null
     */
    protected function guessEndpoint()
    {
        return [
            'url' => url("v1/admin/{$this->getResourceKey()}"),
            'method' => 'get',
        ];
    }

    /**
     * Set the search placeholder.
     *
     * @param  string $placeholder
     * @return self
     */
    public function searchPlaceholder($placeholder)
    {
        $this->searchPlaceholder = $placeholder;

        return $this;
    }
}
