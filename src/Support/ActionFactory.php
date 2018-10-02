<?php

namespace Signifly\Travy\Support;

use Signifly\Travy\Resource;
use Illuminate\Http\Request;

class ActionFactory
{
    public static function make(string $method, Request $request, Resource $resource)
    {
        $actionClass = $resource->getAction($method);

        if (! $actionClass) {
            return null;
        }

        return new $actionClass($request, $resource);
    }
}
