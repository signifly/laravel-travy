<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Concerns\AppliesConcerns;
use Signifly\Travy\Contracts\Table as Contract;

abstract class Table extends Definition implements Contract
{
    use AppliesConcerns;

    public function preparedActions(): array
    {
        return collect($this->actions())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function preparedColumns(): array
    {
        return collect($this->columns())
            ->mapInto(Column::class)
            ->map(function ($column, $index) {
                return $column->order($index + 1)
                    ->jsonSerialize();
            })
            ->toArray();
    }

    public function toSchema(): Schema
    {
        $schema = new Schema([
            'columns' => $this->preparedColumns(),
            'endpoint' => $this->endpoint(),
        ]);

        $this->applyConcerns($schema);

        // Allow doing some final configurations
        if (method_exists($this, 'prepareSchema')) {
            $this->prepareSchema($schema);
        }

        return $schema;
    }

    public function toArray()
    {
        return $this->toSchema()->toArray();
    }
}
