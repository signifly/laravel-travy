<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Database\Eloquent\Model;

class ShowAction extends Action
{
    public function handle() : Model
    {
        return $this->resource->findOrFail($this->getId());
    }
}
