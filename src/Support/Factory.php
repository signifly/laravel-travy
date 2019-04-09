<?php

namespace Signifly\Travy\Support;

abstract class Factory
{
    abstract public function create();

    public static function make($params)
    {
        $params = is_array($params) ? $params : func_get_args();

        return (new static(...$params))->create();
    }
}
