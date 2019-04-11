<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Signifly\Travy\Support\TableFactory;
use Signifly\Travy\Support\DefinitionFactory;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefinitionController extends Controller
{
    public function show(TravyRequest $request)
    {
        if ($request->type == 'table') {
            $namespace = config('travy.definitions.namespace');
            $type = Str::studly($request->route()->parameter('type'));
            $resource = Str::studly($request->resourceKey());
            $class = "{$namespace}\\{$type}\\{$resource}{$type}Definition";

            if (! class_exists($class)) {
                return TableFactory::make($request);
            }
        }

        $definition = DefinitionFactory::make($request);

        return new JsonResponse($definition->build());
    }
}
