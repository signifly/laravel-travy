<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class StoreAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->create($this->input->all());

        $this->syncRelations();

        return $this->respond(
            $model->load($this->resource->with())
        );
    }
}
