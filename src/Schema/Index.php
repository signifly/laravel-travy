<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Concerns\WithModifiers;
use Signifly\Travy\Contracts\Index as Contract;

abstract class Index extends Definition implements Contract
{
    abstract public function pageTitle(): string;

    abstract public function hero(): array;

    abstract public function tabs(): array;

    public function toArray()
    {
        $schema = [
            'pageTitle' => $this->pageTitle(),
            'hero' => $this->hero(),
            'tabs' => $this->tabs(),
        ];

        if ($this instanceof WithModifiers) {
            $schema['modifiers'] = $this->modifiers();
        }

        return $schema;
    }
}
