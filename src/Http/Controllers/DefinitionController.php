<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Support\DefinitionFactory;

class DefinitionController extends Controller
{
    public function show(TravyRequest $request)
    {
        $definition = (new DefinitionFactory($request))->make();

        return new JsonResponse($definition->build());
    }
}
