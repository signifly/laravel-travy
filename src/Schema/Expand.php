<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\Support\FieldCollection;

class Expand implements Arrayable, JsonSerializable
{
    /** @var array */
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return (new Schema([
            'type' => 'fields',
            'fields' => FieldCollection::make($this->fields),
        ]))->toArray();
    }
}
