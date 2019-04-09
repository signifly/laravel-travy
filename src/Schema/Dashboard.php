<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Signifly\Travy\Contracts\Dashboard as Contract;

class Dashboard implements Contract, Arrayable, JsonSerializable, Responsable
{
    /** @var array */
    protected $sections;

    public function __construct(array $sections = [])
    {
        $this->sections = $sections;
    }

    public function sections(): array
    {
        return $this->sections;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $sections = collect($this->sections())
            ->map(function ($section) {
                return $section->jsonSerialize();
            })
            ->toArray();

        return compact('sections');
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->jsonSerialize());
    }
}
