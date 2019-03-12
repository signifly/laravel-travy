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
        $request->resource()->authorizeToCreate($request);

        return $this->dispatch($request->action());
    }

    public function show(TravyRequest $request)
    {
        $request->resource()->authorizeToView($request);

        return $this->dispatch($request->action());
    }

    public function update(TravyRequest $request)
    {
        $request->resource()->authorizeToUpdate($request);

        return $this->dispatch($request->action());
    }

    public function destroy(TravyRequest $request)
    {
        $request->resource()->authorizeToDelete($request);

        return $this->dispatch($request->action());
    }

    public function restore(TravyRequest $request)
    {
        $request->resource()->authorizeToRestore($request);

        return $this->dispatch($request->action());
    }

    public function forceDestroy(TravyRequest $request)
    {
        $request->resource()->authorizeToForceDelete($request);

        return $this->dispatch($request->action());
    }
}
