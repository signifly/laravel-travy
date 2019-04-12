<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Signifly\Travy\Support\ViewFactory;
use Signifly\Travy\Support\TableFactory;
use Signifly\Travy\Support\DefinitionFactory;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefinitionController extends Controller
{
    public function show(TravyRequest $request)
    {
        $namespace = config('travy.definitions.namespace');
        $type = Str::studly($request->route()->parameter('type'));
        $resource = Str::studly($request->resourceKey());
        $class = "{$namespace}\\{$type}\\{$resource}{$type}Definition";

        if (class_exists($class)) {
            $definition = DefinitionFactory::make($request);
            return new JsonResponse($definition->build());
        }

        if ($request->type == 'table') {
            return TableFactory::make($request);
        }

        if ($request->type == 'view') {
            return ViewFactory::make($request);
        }
    }
}
