<?php

namespace Signifly\Travy\Concerns;

use Signifly\Travy\Schema\Batch;

interface WithBatchActions
{
    public function batch(): Batch;
}
