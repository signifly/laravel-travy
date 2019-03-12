<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class UpdateAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $this->guardAgainstModelNotExists($model);

        $model->update($this->request->input('data', []));

        return $this->respondForModel(
            $model->fresh($this->resource->with())
        );
    }
}
