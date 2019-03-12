<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class RestoreAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $model->restore();

        return $this->respondForModel(
            $model->fresh($this->resource->with())
        );
    }
}
