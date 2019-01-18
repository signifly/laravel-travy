<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class StoreAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->create($this->request->input('data'));

        return $this->respondForModel(
            $model->load($this->resource->with())
        );
    }
}
