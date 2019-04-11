<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Collection;

class FieldCollection extends Collection
{
    /**
     * Get the prepared fields.
     *
     * @return array
     */
    public function prepared(): array
    {
        return $this->map->jsonSerialize()->toArray();
    }

    /**
     * Returns the fields default value in data format.
     *
     * @return array
     */
    public function toData(): array
    {
        return $this->mapWithKeys(function ($field) {
            return [$field->attribute => $field->defaultValue ?? ''];
        })->toArray();
    }
}
