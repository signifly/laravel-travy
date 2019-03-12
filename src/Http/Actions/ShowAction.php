<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class ShowAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $this->guardAgainstModelNotExists($model);

        return $this->respondForModel(
            $model->load($this->resource->with())
        );
    }
}
