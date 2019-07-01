<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Str;
use Signifly\Travy\Fields\Actions;
use Signifly\Travy\Fields\Input\Toggle;
use Signifly\Travy\Support\ModelFactory;
use Signifly\Travy\Support\FieldCollection;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefaultTable extends Table
{
    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /** @var \Signifly\Travy\Resource */
    protected $resource;

    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
        $this->resource = $request->resource();
    }

    public function actions(): array
    {
        $resourceKey = $this->request->resourceKey();
        $resourceName = Str::snake($this->resource->displayAs(), ' ');
        $creatableFields = $this->getCreationFields();

        return [
            Modal::make("Add {$resourceName}", 'primary')
                ->icon('plus')
                ->endpoint(url("v1/admin/{$resourceKey}"))
                ->onSubmit($this->creationRedirectTo ?? "/t/{$resourceKey}/{id}")
                ->fields($creatableFields->toArray())
                ->payload(['data' => $creatableFields->toData()]),
        ];
    }

    public function columns(): array
    {
        $columns = $this->getIndexFields();

        // Set actions
        $column = Actions::make('Actions')
            ->actions($this->getColumnActions())
            ->width(120);

        $columns->push($column);

        return $columns->toArray();
    }

    public function defaults(): array
    {
        $defaultSort = collect($this->columns())->first->defaultSort;

        if (! $defaultSort) {
            return [];
        }

        return [
            'sort' => [
                'prop' => $defaultSort->sortBy,
                'order' => $defaultSort->defaultSortOrder,
            ],
        ];
    }

    public function endpoint(): Endpoint
    {
        $url = url("v1/admin/{$this->request->resourceKey()}");

        $endpoint = new Endpoint($url);

        if ($include = $this->resource->allowedIncludes()) {
            $endpoint->addParam('include', $include);
        }

        return $endpoint;
    }

    public function filters(): array
    {
        $fields = new FieldCollection($this->resource->filters());

        if (ModelFactory::softDeletes($this->resource->modelClass())) {
            $fields->push(Toggle::make('Show only deleted', 'trashed'));
        }

        if ($fields->isEmpty()) {
            return [];
        }

        return [
            'data' => $fields->toData(),
            'fields' => $fields->prepared(),
        ];
    }

    public function modifiers(): array
    {
        $fields = new FieldCollection($this->resource->modifiers());

        if ($fields->isEmpty()) {
            return [];
        }

        return [
            'data' => $fields->toData(),
            'fields' => $fields->prepared(),
        ];
    }

    protected function addSearchPlaceholder(): void
    {
        if (! $this->resource->searchable()) {
            return;
        }

        $searchable = $this->resource->getPreparedFields()
            ->toSearchPlaceholder();

        $this->searchPlaceholder = $searchable
            ? __('Search for ').$searchable
            : __('Search...');
    }

    protected function getColumnActions(): array
    {
        $resourceKey = $this->request->resourceKey();

        $showAction = Show::make('View')->url("/t/{$resourceKey}/{id}");

        $deleteAction = Popup::make('Delete')
            ->endpoint(url("v1/admin/{$resourceKey}/{id}"), 'delete');

        if (ModelFactory::softDeletes($this->resource->modelClass())) {
            return [
                $showAction->hide('is_deleted', true),
                $deleteAction->hide('is_deleted', true),
                Popup::make('Restore')
                    ->endpoint(url("v1/admin/{$resourceKey}/{id}/restore"))
                    ->hide('is_deleted', false)
            ];
        }

        return [
            $showAction,
            $deleteAction,
        ];
    }

    protected function getCreationFields(): FieldCollection
    {
        return $this->resource->getPreparedFields()
            ->onlyCreation()
            ->map(function ($field) {
                // Convert text fields to input text
                if ($field->is('text')) {
                    $field->asInput();
                }

                // Set width
                if ($field->width instanceof Width) {
                    $field->withMeta(['width' => $field->width->getOnCreation()]);
                }

                return $field;
            });
    }

    protected function getIndexFields(): FieldCollection
    {
        return $this->resource->getPreparedFields()
            ->onlyIndex()
            ->map(function ($field) {
                if ($field->linkable && ! $field->linksTo) {
                    $field->linksTo = "/t/{$this->request->resourceKey()}/{id}";
                }

                return $field;
            });
    }

    public function toArray()
    {
        // Add search placeholder from resource
        $this->addSearchPlaceholder();

        return parent::toArray();
    }
}
