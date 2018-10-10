<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Travy\Http\Requests\TravyRequest;

class ResourceController extends Controller
{
    public function index(TravyRequest $request)
    {
        $paginator = $this->dispatch($request->action());

        return $this->respondForPaginator(
            $paginator,
            $request->resource()->getModel()
        );
    }

    public function store(TravyRequest $request)
    {
        $model = $this->dispatch($request->action());

        return $this->respondForModel(
            $model->load($request->resource()->with())
        );
    }

    public function show(TravyRequest $request)
    {
        $model = $this->dispatch($request->action());

        return $this->respondForModel(
            $model->load($request->resource()->with())
        );
    }

    public function update(TravyRequest $request)
    {
        $model = $this->dispatch($request->action());

        return $this->respondForModel(
            $model->fresh($request->resource()->with())
        );
    }

    public function destroy(TravyRequest $request)
    {
        $model = $this->dispatch($request->action());

        return $this->respondForModel($model);
    }

    public function restore(TravyRequest $request)
    {
        $model = $this->dispatch($request->action());

        return $this->respondForModel(
            $model->fresh($request->resource()->with())
        );
    }
}
