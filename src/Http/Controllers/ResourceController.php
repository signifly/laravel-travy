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
        $request->resource()->authorizeToCreate();

        return $this->dispatch($request->action());
    }

    public function show(TravyRequest $request)
    {
        $request->resource()->authorizeToView();

        return $this->dispatch($request->action());
    }

    public function update(TravyRequest $request)
    {
        $request->resource()->authorizeToUpdate();

        return $this->dispatch($request->action());
    }

    public function destroy(TravyRequest $request)
    {
        $request->resource()->authorizeToDelete();

        return $this->dispatch($request->action());
    }

    public function restore(TravyRequest $request)
    {
        $request->resource()->authorizeToRestore();

        return $this->dispatch($request->action());
    }

    public function forceDestroy(TravyRequest $request)
    {
        $request->resource()->authorizeToForceDelete();

        return $this->dispatch($request->action());
    }
}
