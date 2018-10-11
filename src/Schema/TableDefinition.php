<?php

namespace Signifly\Travy\Schema;

use Closure;
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
        $resource = $this->request->resource();
        $fields = collect($resource->fields());
        $resolver = new ColumnResolver($this->request);

        $fields->filter(function ($field) {
            return $field->showOnIndex;
        })->each(function ($field) use ($resolver) {
            $column = $resolver->resolve($field);
            $this->addColumnInstance($column);
        });

        $defaultSort = $fields->first(function ($field) {
            return $field->defaultSort;
        });

        if ($defaultSort) {
            $this->addDefault('sort', [
                'prop' => $defaultSort->attribute,
                'order' => $defaultSort->defaultSortOrder,
            ]);
        }

        return $this;
    }

    /**
     * Get filterable fields from the resource's fields.
     *
     * @return self
     */
    public function filtersFromResource()
    {
        $resource = $this->request->resource();
        $fields = collect($resource->filterableFields());
        $resolver = new FilterResolver($this->request);

        $fields->each(function ($field) use ($resolver) {
            $column = $resolver->resolve($field);
            $this->addFilterInstance($column);
        });

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
