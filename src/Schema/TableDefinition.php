<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Str;
use Signifly\Travy\Fields\Input\Toggle;
use Illuminate\Database\Eloquent\SoftDeletes;
use Signifly\Travy\Schema\Concerns\HasColumns;

abstract class TableDefinition extends Definition
{
    use HasColumns;

    /**
     * The batch schema for the definition schema.
     *
     * @var \Signifly\Travy\Schema\Batch
     */
    protected $batchSchema;

    /**
     * The endpoint to redirect to on creation.
     * - defaults to /t/{resource}/{id}.
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
    public function build(): array
    {
        $this->schema();

        if (! $this->endpoint) {
            $this->guessEndpoint();
        }

        $schema = [
            'columns' => $this->preparedColumns(),
            'endpoint' => $this->endpoint->toArray(),
            'defaults' => $this->defaults,
        ];

        if ($this->hasActions()) {
            array_set($schema, 'actions', $this->preparedActions());
        }

        if ($this->hasFilters()) {
            array_set($schema, 'filters', $this->filters);
        }

        if ($this->hasModifiers()) {
            array_set($schema, 'modifiers', $this->modifiers);
        }

        if ($this->searchPlaceholder) {
            array_set($schema, 'search.placeholder', $this->searchPlaceholder);
        }

        if ($this->batchSchema) {
            array_set($schema, 'batch', $this->batchSchema->jsonSerialize());
        }

        return $schema;
    }

    /**
     * Build the batch schema.
     *
     * @return \Signifly\Travy\Schema\Batch
     */
    public function buildBatch(...$args)
    {
        $this->batchSchema = Batch::make(...$args);

        return $this->batchSchema;
    }

    /**
     * Get the batch label from the resource.
     *
     * @return string
     */
    public function batchLabelFromResource()
    {
        $fields = $this->request->resource()->getPreparedFields();

        $field = $fields->first(function ($field) {
            return $field->isBatchLabel;
        });

        return $field ? $field->attribute : '';
    }

    /**
     * Get columns from the resource's fields.
     *
     * @return self
     */
    public function columnsFromResource()
    {
        $fields = $this->request->resource()->getPreparedFields();

        $columnFields = $fields->filter(function ($field) {
            return $field->showOnIndex;
        })
            ->map(function ($field) {
                if ($field->linkable && ! $field->linksTo) {
                    $field->linksTo = "/t/{$this->request->resourceKey()}/{id}";
                }

                // Set the width
                if ($width = optional($field->width)->getOnIndex()) {
                    $field->withMeta(['width' => $width]);
                }

                return $field;
            })
            ->values();

        $this->columns($columnFields->toArray());

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
        })->map(function ($field) {
            return __($field->name);
        })->implode(', ');

        $this->searchPlaceholder(
            $searchable ? __('Search for ').$searchable : __('Search...')
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
        })
            ->map(function ($field) {
                // Convert text fields to input text
                if ($field->component == 'text') {
                    $field->asInput();
                }

                // Set width
                if ($field->width instanceof Width) {
                    $field->withMeta(['width' => $field->width->getOnCreation()]);
                }

                return $field;
            })
            ->values();

        // Prepare payload
        $payload = [];
        $creatableFields->each(function ($field) use (&$payload) {
            array_set($payload, $field->attribute, $field->defaultValue ?? '');
        });

        $action = Action::make("Add {$resourceName}", 'primary')
            ->icon('plus')
            ->type('modal')
            ->endpoint(url("v1/admin/{$resourceKey}"))
            ->onSubmit($this->creationRedirectTo ?? "/t/{$resourceKey}/{id}")
            ->fields($creatableFields->toArray())
            ->payload(['data' => $payload]);

        $this->addAction($action);

        return $action;
    }

    /**
     * Get filterable fields from the resource.
     *
     * @return self
     */
    public function filtersFromResource()
    {
        $fields = collect($this->request->resource()->filters());

        $modelTraits = collect(class_uses_recursive($this->request->resource()->getModel()));

        if ($modelTraits->contains(SoftDeletes::class)) {
            $fields->push(Toggle::make('Show only deleted', 'trashed'));
        }

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
     * Load columns, filters, includes and modifiers from resource.
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
        $url = url("v1/admin/{$this->getResourceKey()}");

        return $this->endpoint($url, function ($endpoint) {
            if ($this->hasIncludes()) {
                $endpoint->addParam('include', $this->includes);
            }
        });
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
