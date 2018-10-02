<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class DestroyAction extends Action
{
    public function handle() : Model
    {
        $model = $this->resource->findOrFail($this->getId());

        $model->delete();

        return $model;
    }
}
