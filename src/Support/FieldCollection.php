<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Collection;

class FieldCollection extends Collection
{
    /**
     * Get only fields that has showOnCreation.
     *
     * @return self
     */
    public function onlyCreation(): self
    {
        return $this->filter->showOnCreation
            ->values();
    }

    /**
     * Get only fields that has showOnIndex.
     *
     * @return self
     */
    public function onlyIndex(): self
    {
        return $this->filter->showOnIndex
            ->values();
    }

    /**
     * Get only fields that has showOnUpdate.
     *
     * @return self
     */
    public function onlyUpdate(): self
    {
        return $this->filter->showOnUpdate
            ->values();
    }

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

    /**
     * Return the fields as a search placeholder.
     *
     * @return string
     */
    public function toSearchPlaceholder(): string
    {
        return $this->filter->searchable
            ->map(function ($field) {
                return __($field->name);
            })
            ->implode(', ');
    }
}
