<?php

namespace Signifly\Travy;

use Illuminate\Http\Request;
use Signifly\Travy\Fields\Tab;
use Spatie\QueryBuilder\Filter;
use Signifly\Travy\Support\RulesetSorter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Signifly\Travy\Http\Filters\SearchFilter;
use Signifly\Travy\Http\Filters\TrashedFilter;

abstract class Resource
{
    /** @var array */
    protected $actions = [];

    /** @var string */
    protected $displayAs;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var array */
    protected $globalScopes = [];

    /** @var array */
    protected $includes = [];

    /** @var array */
    protected $searchable = [];

    /** @var array */
    protected $sorts = ['*'];

    /** @var array */
    protected $with = [];

    /** @var array */
    protected $withCount = [];

    /**
     * Create a new resource.
     */
    public function __construct()
    {
        $this->defaultActions();
    }

    /**
     * Get the model.
     *
     * @return string
     */
    public function getModel() : string
    {
        return $this->model ?? 'App\\Models\\' . class_basename(get_called_class());
    }

    /**
     * Create a new model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newModelInstance()
    {
        $model = $this->getModel();
        return new $model;
    }

    /**
     * Create a new query for the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        $query = $this->newModelInstance()->query();

        $this->applyGlobalScopes($query);

        return $query;
    }

    /**
     * The actions that should be merged with the default actions.
     *
     * @return array
     */
    protected function actions() : array
    {
        return [];
    }

    /**
     * The default actions.
     *
     * @return self
     */
    protected function defaultActions(array $overwrites = [])
    {
        $this->actions = array_merge([
            'index' => Http\Actions\IndexAction::class,
            'store' => Http\Actions\StoreAction::class,
            'show' => Http\Actions\ShowAction::class,
            'update' => Http\Actions\UpdateAction::class,
            'destroy' => Http\Actions\DestroyAction::class,
            'restore' => Http\Actions\RestoreAction::class,
        ], $overwrites);

        return $this;
    }

    /**
     * The default filters.
     *
     * @return array
     */
    protected function defaultFilters() : array
    {
        $filters = [];

        $modelTraits = collect(class_uses_recursive($this->getModel()));

        if ($modelTraits->contains(SoftDeletes::class)) {
            array_push(
                $filters,
                Filter::custom('trashed', TrashedFilter::class)
            );
        }

        if ($this->searchable()) {
            array_push(
                $filters,
                Filter::custom('search', new SearchFilter($this->getSearchable()))
            );
        }

        return $filters;
    }

    /**
     * Get the display as value.
     *
     * @return string
     */
    public function displayAs() : string
    {
        return $this->displayAs ?? class_basename(get_called_class());
    }

    /**
     * Define filters that should be merged with the default filters.
     *
     * @return array
     */
    protected function filters() : array
    {
        return [];
    }

    /**
     * Determines if the resource is searchable.
     *
     * @return bool
     */
    protected function searchable()
    {
        return count($this->getSearchable()) > 0;
    }

    /**
     * Get the allowed filters.
     *
     * @return array
     */
    public function allowedFilters() : array
    {
        return array_merge($this->defaultFilters(), $this->filters());
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    public function allowedIncludes() : array
    {
        return $this->includes;
    }

    /**
     * Get the allowed sorts.
     *
     * @return array
     */
    public function allowedSorts() : array
    {
        return $this->sorts;
    }

    /**
     * Apply global scopes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function applyGlobalScopes($query)
    {
        $scopes = collect($this->globalScopes);

        if ($scopes->isEmpty()) {
            return;
        }

        $scopes->each(function ($scope) use ($query) {
            $query->$scope();
        });
    }

    /**
     * The validation rules for the resource.
     *
     * @return array
     */
    public function creationRules() : array
    {
        return [];
    }

    /**
     * The fields for the resource.
     *
     * @return array
     */
    public function fields() : array
    {
        return [];
    }

    /**
     * The filterable fields for creation.
     *
     * @return array
     */
    public function filterableFields() : array
    {
        return [];
    }

    /**
     * Retrieve an action by the specified key.
     *
     * @param  string $key
     * @return string
     */
    public function getAction(string $key)
    {
        return array_get($this->getActions(), $key);
    }

    /**
     * Retrieves all actions.
     *
     * @return array
     */
    public function getActions()
    {
        return array_merge($this->actions, $this->actions());
    }

    /**
     * The validation rules for creation.
     *
     * @param  Request $request
     * @return array
     */
    public function getCreationRules(Request $request)
    {
        $rules = collect($this->fields())
            ->filter(function ($field) {
                return $field->showOnCreation;
            })
            ->mapWithKeys(function ($field) use ($request) {
                return $field->getCreationRules($request);
            })->toArray();

        return RulesetSorter::makeFor(
            array_merge_recursive($rules, $this->creationRules())
        );
    }

    public function getPreparedFields()
    {
        return collect($this->fields())
            ->map(function ($field) {
                if ($field instanceof Tab) {
                    return $field->fields;
                }

                return [$field];
            })
            ->flatten();
    }

    /**
     * The searchable columns.
     *
     * @return array
     */
    public function getSearchable() : array
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
     * The validation rules for updates.
     *
     * @param  Request $request
     * @return array
     */
    public function getUpdateRules(Request $request)
    {
        $rules = collect($this->fields())
            ->filter(function ($field) {
                return $field->showOnUpdate;
            })
            ->mapWithKeys(function ($field) use ($request) {
                return $field->getUpdateRules($request);
            })->toArray();

        return RulesetSorter::makeFor(
            array_merge_recursive($rules, $this->updateRules())
        );
    }

    /**
     * Set an action.
     *
     * @param string $key
     * @param string $action The action class
     */
    public function setAction(string $key, string $action)
    {
        $this->actions[$key] = $action;

        return $this;
    }

    /**
     * The validation rules for updates.
     *
     * @return array
     */
    public function updateRules() : array
    {
        return [];
    }

    public function with()
    {
        return $this->with;
    }

    public function withCount()
    {
        return $this->withCount;
    }

    public function __call($method, $parameters)
    {
        return $this->newQuery()->$method(...$parameters);
    }
}
