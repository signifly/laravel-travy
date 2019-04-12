<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Signifly\Travy\Contracts\View as Contract;

abstract class View implements Contract, Arrayable, JsonSerializable, Responsable
{
    /** @var bool */
    protected $activity = false;

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

    public function modifiers(): array
    {
        return [];
    }

    public function sidebars(): array
    {
        return [];
    }

    public function preparedActions(): array
    {
        return collect($this->actions())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function preparedSidebars(): array
    {
        return collect($this->sidebars())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function preparedTabs(): array
    {
        return collect($this->tabs())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $schema = [
            'tabs' => $this->preparedTabs(),
            'header' => $this->header(),
            'endpoint' => $this->endpoint()->toArray(),
        ];

        if ($this->activity) {
            Arr::set($schema, 'activity', (object) []);
        }

        if (count($this->actions()) > 0) {
            Arr::set($schema, 'actions', $this->preparedActions());
        }

        if (count($this->modifiers()) > 0) {
            Arr::set($schema, 'modifiers', $this->modifiers());
        }

        if (count($this->sidebars()) > 0) {
            Arr::set($schema, 'sidebars', $this->sidebars());
        }

        return $schema;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->jsonSerialize());
    }
}
