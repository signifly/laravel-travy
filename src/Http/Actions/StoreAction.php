<?php

namespace Signifly\Travy\Http\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class StoreAction extends Action
{
    public function handle(): Responsable
    {
        try {
            DB::beginTransaction();

            $model = $this->resource->create($this->input->all());

            $this->syncRelations();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $this->respond(
            $model->load($this->resource->with())
        );
    }
}
