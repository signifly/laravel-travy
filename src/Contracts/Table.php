<?php

namespace Signifly\Travy\Contracts;

use Signifly\Travy\Schema\Endpoint;

interface Table
{
    public function columns(): array;

    public function endpoint(): Endpoint;
}
