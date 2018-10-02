<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class UpdateAction extends Action
{
    public function handle() : Model
    {
        $model = $this->resource->findOrFail($this->getId());

        $model->update($this->request->all());

        return $model;
    }
}
