<?php

namespace Signifly\Travy\Http\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class UpdateAction extends Action
{
    public function handle(): Responsable
    {
        try {
            DB::beginTransaction();

            $model = $this->resource->model();

            $model->update($this->input->all());

            $this->syncRelations();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $this->respond(
            $model->fresh($this->resource->with())
        );
    }
}
