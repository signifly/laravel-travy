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
        $fields = new FieldCollection($this->resource->getPreparedFields()->toArray());
        $resourceKey = $this->request->resourceKey();
        $resourceName = Str::snake($this->resource->displayAs());

        $creatableFields = $fields->filter->showOnCreation
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

        return [
            Action::make("Add {$resourceName}", 'primary')
                ->icon('plus')
                ->type('modal')
                ->endpoint(url("v1/admin/{$resourceKey}"))
                ->onSubmit($this->creationRedirectTo ?? "/t/{$resourceKey}/{id}")
                ->fields($creatableFields->toArray())
                ->payload(['data' => $creatableFields->toData()]),
        ];
    }

    public function columns(): array
    {
        $fields = $this->resource->getPreparedFields();

        $columns = $fields->filter->showOnIndex
            ->map(function ($field) {
                if ($field->linkable && ! $field->linksTo) {
                    $field->linksTo = "/t/{$this->request->resourceKey()}/{id}";
                }

                return new Column($field);
            })
            ->values();

        // Set actions
        $column = Column::make(
            Actions::make('Actions')
                ->actions([
                    Action::make('View')
                        ->type('show')
                        ->endpoint(
                            "/t/{$this->request->resourceKey()}/{id}",
                            function ($endpoint) {
                                $endpoint->usingMethod('get');
                            }
                        )
                        ->hide('is_deleted', true),

                    Action::make('Delete')
                        ->type('popup')
                        ->endpoint(
                            url("v1/admin/{$this->request->resourceKey()}/{id}"),
                            function ($endpoint) {
                                $endpoint->usingMethod('delete');
                            }
                        )
                        ->text('Are you sure? Please confirm this action.')
                        ->hide('is_deleted', true),

                    Action::make('Restore')
                        ->type('popup')
                        ->endpoint(url("v1/admin/{$this->request->resourceKey()}/{id}/restore"))
                        ->text('Are you sure? Please confirm this action.')
                        ->hide('is_deleted', false),
                ])
                ->width(120)
        );

        $columns->push($column);

        return $columns->toArray();
    }

    public function defaults(): array
    {
        $fields = $this->resource->getPreparedFields();

        $defaultSort = $fields->first(function ($field) {
            return $field->defaultSort;
        });

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
        $fields = new FieldCollection($this->resource->filters());

        if ($fields->isEmpty()) {
            return [];
        }

        return [
            'data' => $fields->toData(),
            'fields' => $fields->prepared(),
        ];
    }

    public function toArray()
    {
        // Add search placeholder from resource
        $fields = $this->resource->getPreparedFields();

        $searchable = $fields->filter->searchable
            ->map(function ($field) {
                return __($field->name);
            })
            ->implode(', ');

        $this->searchPlaceholder = $searchable
            ? __('Search for ').$searchable
            : __('Search...');

        return parent::toArray();
    }
}
