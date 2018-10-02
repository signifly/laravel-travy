<?php

namespace Signifly\Travy\Concerns;

use Closure;

trait Buildable
{
    /**
     * Build the definition schema from a closure.
     *
     * @param  Closure $callable
     * @return array
     */
    public static function build(Closure $callable)
    {
        $schema = new static;

        $callable($schema);

        return $schema->toArray();
    }
}
