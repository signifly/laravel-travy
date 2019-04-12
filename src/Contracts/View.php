<?php

namespace Signifly\Travy\Contracts;

use Signifly\Travy\Schema\Endpoint;

interface View
{
    public function tabs(): array;

    public function header(): array;

    public function endpoint(): Endpoint;
}
