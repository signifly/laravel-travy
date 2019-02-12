<?php

namespace Signifly\Travy\Support;

use Illuminate\Http\Request;
use Signifly\Travy\Resource;
use Illuminate\Http\Response;

class ActionFactory
{
    public static function make(string $method, Request $request, Resource $resource)
    {
        // Abort 404 if the action is guarded
        abort_if(
            in_array($method, $resource->getGuardedActions()),
            Response::HTTP_NOT_FOUND
        );

        $actionClass = $resource->getAction($method);

        if (! $actionClass) {
            return;
        }

        return new $actionClass($request, $resource);
    }
}
