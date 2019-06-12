<?php

namespace Signifly\Travy\Http\Actions;

use Illuminate\Contracts\Support\Responsable;

class UpdateAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $model->update($this->input->all());

        $this->syncRelations();

        return $this->respond(
            $model->fresh($this->resource->with())
        );
    }
}
