<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class StoreAction extends Action
{
    public function handle() : Model
    {
        return $this->resource->create($this->request->all());
    }
}
