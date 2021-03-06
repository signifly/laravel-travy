<?php

namespace Signifly\Travy;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Fields\Tab;
use Illuminate\Support\Collection;
use Signifly\Travy\Fields\Sidebar;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Signifly\Travy\Support\ModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Signifly\Travy\Support\RulesetSorter;
use Signifly\Travy\Support\FieldCollection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Signifly\Travy\Http\Filters\SearchFilter;
use Signifly\Travy\Http\Filters\TrashedFilter;
use Signifly\Travy\Support\RelationCollection;
use Illuminate\Http\Resources\DelegatesToResource;

abstract class Resource
{
    use Authorizable;
    use DelegatesToResource;

    /**
     * The request actions.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Customize how the resource name is displayed.
     *
     * @var string
     */
    protected $displayAs;

    /**
     * The model class name.
     *
     * @var string
     */
    protected $model;

    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $resource;

    /**
     * Apply the specified scopes by default on a query.
     *
     * @var array
     */
    protected $globalScopes = [];

    /**
     * Disallow calling the specified request actions.
     *
     * @var array
     */
    protected $guardedActions = [];

    /**
     * The relations to include during the index request.
     *
     * @var array
     */
    protected $includes = [];

    /**
     * The allowed attributes to search.
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * The allowed attributes to sort by.
     *
     * @var array
     */
    protected $sorts = [];

    /**
     * The relations to eager load during the show request.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The relations to count during the index request.
     *
     * @var array
     */
    protected $withCount = [];

    /**
     * Create a new resource.
     */
    public function __construct(Model $model)
    {
        $this->resource = $model;
        $this->actions = $this->defaultActions();
    }

    /**
     * Get the model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model(): Model
    {
        return $this->resource;
    }

    /**
     * Get the model class.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return $this->model ?? (isset($this->resource)
            ? get_class($this->resource)
            : $this->guessModel());
    }

    /**
     * Try to guess the model name.
     *
     * @return string
     */
    protected function guessModel(): string
    {
        return config('travy.models.namespace').'\\'.class_basename(static::class);
    }

    /**
     * Create a new query for the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery(): Builder
    {
        $query = $this->model()->newQuery();

        $this->applyGlobalScopes($query);

        return $query;
    }

    /**
     * The actions that should be merged with the default actions.
     *
     * @return array
     */
    protected function actions(): array
    {
        return [];
    }

    /**
     * Get the default actions.
     *
     * @return array
     */
    protected function defaultActions(): array
    {
        return [
            'index' => Http\Actions\IndexAction::class,
            'store' => Http\Actions\StoreAction::class,
            'show' => Http\Actions\ShowAction::class,
            'update' => Http\Actions\UpdateAction::class,
            'destroy' => Http\Actions\DestroyAction::class,
            'restore' => Http\Actions\RestoreAction::class,
            'forceDestroy' => Http\Actions\ForceDestroyAction::class,
        ];
    }

    /**
     * Get the default query filters.
     *
     * @return array
     */
    protected function defaultQueryFilters(): array
    {
        $filters = [];

        if (ModelFactory::softDeletes($this->modelClass())) {
            $filters[] = AllowedFilter::custom('trashed', new TrashedFilter());
        }

        if ($this->searchable()) {
            $filters[] = AllowedFilter::custom('search', new SearchFilter($this->getSearchable()));
        }

        return $filters;
    }

    /**
     * Get the display as value.
     *
     * @return string
     */
    public function displayAs(): string
    {
        return $this->displayAs ?? class_basename(get_called_class());
    }

    /**
     * Define query filters that should be merged
     * with the default query filters.
     *
     * @return array
     */
    protected function queryFilters(): array
    {
        return [];
    }

    /**
     * Determines if the resource is searchable.
     *
     * @return bool
     */
    public function searchable(): bool
    {
        return count($this->getSearchable()) > 0;
    }

    /**
     * Get the allowed filters.
     *
     * @return array
     */
    public function allowedFilters(): array
    {
        return array_merge($this->defaultQueryFilters(), $this->queryFilters());
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    public function allowedIncludes(): array
    {
        return $this->includes;
    }

    /**
     * Get the allowed sorts.
     *
     * @return array
     */
    public function allowedSorts(): array
    {
        $sortableFields = $this->getPreparedFields()
            ->filter(function ($field) {
                return $field->sortable;
            })
            ->map(function ($field) {
                return $field->sortBy;
            })
            ->values()
            ->toArray();

        return array_merge($sortableFields, $this->sorts);
    }

    /**
     * Apply global scopes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function applyGlobalScopes(Builder $query): void
    {
        collect($this->globalScopes)
            ->each(function ($scope) use ($query) {
                $query->$scope();
            });
    }

    /**
     * Save a new record to the database for the associated Eloquent model.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model
    {
        $model = $this->resource->create($attributes);

        $this->setModel($model);

        return $model;
    }

    /**
     * The validation rules for the resource.
     *
     * @return array
     */
    public function creationRules(): array
    {
        return [];
    }

    /**
     * The fields for the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * The filters fields for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * The modifiers fields for the resource.
     *
     * @return array
     */
    public function modifiers(): array
    {
        return [];
    }

    /**
     * Retrieve an action by the specified key.
     *
     * @param  string $key
     * @return string
     */
    public function getAction(string $key): string
    {
        return Arr::get($this->getActions(), $key);
    }

    /**
     * Retrieves all actions.
     *
     * @return array
     */
    public function getActions(): array
    {
        return array_merge($this->actions, $this->actions());
    }

    /**
     * Get the guarded actions.
     *
     * @return array
     */
    public function getGuardedActions(): array
    {
        return $this->guardedActions;
    }

    /**
     * The validation rules for creation.
     *
     * @param  Request $request
     * @return array
     */
    public function getCreationRules(Request $request): array
    {
        $rules = $this->getPreparedFields()
            ->filter(function ($field) {
                return $field->showOnCreation;
            })
            ->mapWithKeys(function ($field) use ($request) {
                return $field->getCreationRules($request);
            })
            ->toArray();

        return RulesetSorter::makeFor(
            array_merge_recursive($rules, $this->creationRules())
        );
    }

    /**
     * The prepared fields.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPreparedFields(): Collection
    {
        return FieldCollection::make($this->fields())
            ->reject(function ($field) {
                return $field instanceof Sidebar;
            })
            ->map(function ($field) {
                if ($field instanceof Tab) {
                    return $field->getPreparedFields();
                }

                return [$field];
            })
            ->values()
            ->flatten();
    }

    /**
     * Get the relations for the resource.
     *
     * @return \Signifly\Travy\Support\RelationCollection
     */
    public function getRelations(): RelationCollection
    {
        return RelationCollection::fromResource($this);
    }

    /**
     * The searchable columns.
     *
     * @return array
     */
    public function getSearchable(): array
    {
        $fields = $this->getPreparedFields()
            ->filter(function ($field) {
                return $field->searchable;
            })
            ->map(function ($field) {
                return $field->attribute;
            })
            ->values()
            ->toArray();

        return array_merge($fields, $this->searchable);
    }

    /**
     * The filters to use for sanitzing input data.
     *
     * @return array
     */
    public function getSanitizeFilters(): array
    {
        return $this->getPreparedFields()
            ->mapWithKeys(function ($field) {
                return $field->getSanitizeFilters();
            })
            ->filter()
            ->toArray();
    }

    /**
     * The validation rules for updates.
     *
     * @param  Request $request
     * @return array
     */
    public function getUpdateRules(Request $request): array
    {
        $rules = $this->getPreparedFields()
            ->filter(function ($field) {
                return $field->showOnUpdate;
            })
            ->mapWithKeys(function ($field) use ($request) {
                return $field->getUpdateRules($request);
            })
            ->toArray();

        return RulesetSorter::makeFor(
            array_merge_recursive($rules, $this->updateRules())
        );
    }

    /**
     * Set the request action for a given key.
     *
     * @param string $key
     * @param string $action The action class
     */
    public function setAction(string $key, string $action): self
    {
        $this->actions[$key] = $action;

        return $this;
    }

    /**
     * Set the model instance on the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function setModel(Model $model): self
    {
        $this->resource = $model;

        return $this;
    }

    /**
     * The validation rules for updates.
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [];
    }

    /**
     * Get the relations that should be eager loaded.
     *
     * @return array
     */
    public function with(): array
    {
        return $this->with;
    }

    /**
     * Get the relations that should be counted.
     *
     * @return array
     */
    public function withCount(): array
    {
        return $this->withCount;
    }
}
