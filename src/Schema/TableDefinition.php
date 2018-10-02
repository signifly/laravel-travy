<?php

namespace Signifly\Travy\Schema;

use Closure;
use Signifly\Travy\Concerns\HasColumns;
use Signifly\Travy\Concerns\HasFilters;

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
