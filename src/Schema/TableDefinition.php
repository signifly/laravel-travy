<?php

namespace Signifly\Travy\Schema;

use Closure;
use Illuminate\Support\Str;
use Signifly\Travy\Support\FieldResolver;
use Signifly\Travy\Support\ColumnResolver;
use Signifly\Travy\Support\FilterResolver;
use Signifly\Travy\Schema\Concerns\HasColumns;
use Signifly\Travy\Schema\Concerns\HasFilters;

abstract class TableDefinition extends Definition
{
    use HasColumns;
    use HasFilters;

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
            array_set($schema, 'filters', $this->preparedFilters());
        }

        if ($this->hasIncludes()) {
            array_set($schema, 'includes', $this->includes);
        }

        if ($this->hasModifiers()) {
            array_set($schema, 'modifiers', $this->preparedModifiers());
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
        $fields = collect($this->request->resource()->fields());
        $resolver = new ColumnResolver($this->request);

        $fields->filter(function ($field) {
            return $field->showOnIndex;
        })->each(function ($field) use ($resolver) {
            $column = $resolver->resolve($field);
            $this->addColumnInstance($column);
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
        $fields = collect($resource->fields());
        $resolver = new FieldResolver($this->request);
        $resourceKey = $this->request->resourceKey();
        $resourceName = str_replace('-', ' ', Str::kebab($resource->displayAs()));

        $action = $this->addAction("Add {$resourceName}", 'primary')
            ->icon('plus')
            ->type('modal')
            ->endpoint(url("v1/admin/{$resourceKey}"))
            ->onSubmit($this->creationRedirectTo ?? "/t/{$resourceKey}/{id}");

        $creatableFields = $fields->filter(function ($field) {
            return $field->showOnCreation;
        });

        // Add fields to action
        $creatableFields->each(function ($field) use ($action, $resolver) {
            $schemaField = $resolver->resolve($field);
            $action->addFieldInstance($schemaField);
        });

        // Set default data
        $defaultData = $creatableFields->mapWithKeys(function ($field) {
            return [$field->attribute => $field->defaultValue ?? ''];
        });

        $action->data($defaultData->toArray());

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
        $resolver = new FilterResolver($this->request);

        $fields->each(function ($field) use ($resolver) {
            $column = $resolver->resolve($field);
            $this->addFilterInstance($column);
        });

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

        return $this;
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
