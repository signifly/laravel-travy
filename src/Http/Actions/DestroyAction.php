<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class DestroyAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $this->guardAgainstModelNotExists($model);

        $model->delete();

        return $this->respondForModel($model);
    }
}
