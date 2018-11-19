<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class ForceDestroyAction extends Action
{
    public function handle() : Model
    {
        $model = $this->resource->withTrashed()->findOrFail($this->getId());

        $model->forceDelete();

        return $model;
    }
}
