<?php

namespace Signifly\Travy\Schema\Concerns;

use Signifly\Travy\Support\UnmappedProp;

trait CanDisable
{
    public function disable(bool $value = true): self
    {
        return $this->withProps(['disabled' => new UnmappedProp($value)]);
    }
}
