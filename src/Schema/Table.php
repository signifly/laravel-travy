<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Signifly\Travy\Contracts\Table as Contract;

abstract class Table implements Contract, Arrayable, JsonSerializable, Responsable
{
    /** @var bool */
    protected $pagination = true;

    /** @var string */
    protected $channel;

    /** @var string */
    protected $creationRedirectTo;

    /** @var string */
    protected $searchPlaceholder;

    /** @var \Illuminate\Http\Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function actions(): array
    {
        return [];
    }

    public function batch(): ?Batch
    {
        return null;
    }

    public function filters(): array
    {
        return [];
    }

    public function modifiers(): array
    {
        return [];
    }

    public function preparedActions(): array
    {
        return collect($this->actions())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function preparedColumns(): array
    {
        return collect($this->columns())
            ->mapInto(Column::class)
            ->map(function ($column, $index) {
                return $column->setWidth()
                    ->order($index + 1)
                    ->jsonSerialize();
            })
            ->toArray();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $schema = [
            'columns' => $this->preparedColumns(),
            'defaults' => $this->defaults(),
            'endpoint' => $this->endpoint()->toArray(),
        ];

        if ($this->pagination) {
            Arr::set($schema, 'pagination', (object) []);
        }

        if (count($this->actions()) > 0) {
            Arr::set($schema, 'actions', $this->preparedActions());
        }

        if (count($this->filters()) > 0) {
            Arr::set($schema, 'filters', $this->filters());
        }

        if (count($this->modifiers()) > 0) {
            Arr::set($schema, 'modifiers', $this->modifiers());
        }

        if ($this->searchPlaceholder) {
            Arr::set($schema, 'search.placeholder', $this->searchPlaceholder);
        }

        if ($batch = $this->batch()) {
            Arr::set($schema, 'batch', $batch->jsonSerialize());
        }

        if ($this->channel) {
            Arr::set($schema, 'ws.channel', $this->channel);
        }

        return $schema;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->jsonSerialize());
    }
}
