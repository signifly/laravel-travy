<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class ForceDestroyAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->withTrashed()->findOrFail($this->getId());

        $model->forceDelete();

        return $this->respondForModel($model);
    }
}
