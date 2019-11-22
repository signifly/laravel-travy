<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;

abstract class Definition implements Arrayable, JsonSerializable, Responsable
{
    /** @var \Illuminate\Http\Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function toArray();

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->jsonSerialize());
    }
}
