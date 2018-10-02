<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class RestoreAction extends Action
{
    public function handle() : Model
    {
        $model = $this->resource->withTrashed()
            ->findOrFail($this->getId());

        $model->restore();

        return $model;
    }
}
