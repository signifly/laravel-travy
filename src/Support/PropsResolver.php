<?php

namespace Signifly\Travy\Support;

class PropsResolver
{
    public function resolve(array $props): array
    {
        return collect($props)->mapWithKeys(function ($value, $key) {
            if (is_array($value)) {
                $value = (new self())->resolve($value);
            } elseif ($value instanceof UnmappedProp) {
                $key = "_{$key}";
                $value = $value->getValue();
            }

            return [$key => $value];
        })->all();
    }
}
