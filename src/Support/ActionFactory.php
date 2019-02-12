<?php

namespace Signifly\Travy\Support;

use Illuminate\Http\Request;
use Signifly\Travy\Resource;

class ActionFactory
{
    public static function make(string $method, Request $request, Resource $resource)
    {
        $actionClass = $resource->getAction($method);

        if (!$actionClass) {
            return;
        }

        return new $actionClass($request, $resource);
    }
}
