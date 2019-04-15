<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Routing\Controller;
use Signifly\Travy\Support\DefinitionFactory;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefinitionController extends Controller
{
    public function show(TravyRequest $request)
    {
        return DefinitionFactory::make($request);
    }
}
