<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class ShowAction extends Action
{
    public function handle() : Responsable
    {
        $model = $this->resource->findOrFail($this->getId());

        return $this->respondForModel(
            $model->load($this->resource->with())
        );
    }
}
