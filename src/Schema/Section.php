<?php

namespace Signifly\Travy\Schema;

use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\Schema\Concerns\HasFields;

class Section implements Arrayable
{
    use HasFields;

    protected $key;

    protected $title;

    public function __construct($key, $title)
    {
        $this->key = $key;
        $this->title = $title;
    }

    public function toArray()
    {
        return [
            'id'     => $this->key,
            'title'  => $this->title,
            'fields' => $this->preparedFields(),
        ];
    }
}
