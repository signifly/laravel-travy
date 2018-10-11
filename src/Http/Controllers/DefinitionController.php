<?php

namespace Signifly\Travy\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Signifly\Travy\Support\DefinitionFactory;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefinitionController extends Controller
{
    public function show(TravyRequest $request)
    {
        $definition = (new DefinitionFactory($request))->make();

        $cacheKey = $this->getCacheKeyFor($definition);
        $cacheTtl = 60; // minutes

        return Cache::remember($cacheKey, $cacheTtl, function () use ($definition) {
            return new JsonResponse($definition->build());
        });
    }

    /**
     * Get the cache key for the definition.
     *
     * @param  \Signifly\Travy\Schema\Definition $definition
     * @return string
     */
    protected function getCacheKeyFor($definition)
    {
        $class = get_class($definition);

        return md5($class);
    }
}
