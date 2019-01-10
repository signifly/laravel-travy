<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Travy\Http\Requests\TravyRequest;

class ResourceController extends Controller
{
    public function index(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function store(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function show(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function update(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function destroy(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function restore(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }

    public function forceDestroy(TravyRequest $request)
    {
        return $this->dispatch($request->action());
    }
}
