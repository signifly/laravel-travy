<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Arr;

class ScopesApplier
{
    public function apply(array $props, array $scopes, int $depth = 0): array
    {
        collect($scopes)->each(function ($scope, $key) use (&$props) {
            data_set($props, $key, Arr::prepend(data_get($props, $key), $scope, '@scope'));
        });

        return $props;
    }
}
