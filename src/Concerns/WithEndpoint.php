<?php

namespace Signifly\Travy\Concerns;

use Signifly\Travy\Schema\Endpoint;

interface WithEndpoint
{
    public function endpoint(): Endpoint;
}
