<?php

namespace Signifly\Travy\Http\Controllers;

use Signifly\Travy\Http\Requests\TravyRequest;

class ResourceController extends Controller
{
    protected $request;

    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $paginator = $this->dispatch($this->request->action());

        return $this->respondForPaginator(
            $paginator,
            $this->request->resource()->getModel()
        );
    }

    public function store()
    {
        $model = $this->dispatch($this->request->action());

        return $this->respondForModel(
            $model->load($this->request->resource()->with())
        );
    }

    public function show()
    {
        $model = $this->dispatch($this->request->action());

        return $this->respondForModel(
            $model->load($this->request->resource()->with())
        );
    }

    public function update()
    {
        $model = $this->dispatch($this->request->action());

        return $this->respondForModel(
            $model->fresh($this->request->resource()->with())
        );
    }

    public function destroy()
    {
        $model = $this->dispatch($this->request->action());

        return $this->respondForModel($model);
    }

    public function restore()
    {
        $model = $this->dispatch($this->request->action());

        return $this->respondForModel(
            $model->fresh($this->request->resource()->with())
        );
    }
}
