<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Support\Arr;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Subtable implements JsonSerializable
{
    use HasEndpoint;

    /** @var array */
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public static function make(...$args)
    {
        return new static(...$args);
    }

    public function preparedColumns(): array
    {
        return collect($this->columns())
            ->mapInto(Column::class)
            ->map(function ($column, $index) {
                return $column->setWidth()
                    ->order($index + 1)
                    ->jsonSerialize();
            })
            ->toArray();
    }

    public function jsonSerialize()
    {
        $schema = [
            'columns' => $this->preparedColumns(),
        ];

        if ($this->endpoint) {
            Arr::set($schema, 'endpoint', $this->endpoint->toArray());
        }

        return $schema;
    }
}
