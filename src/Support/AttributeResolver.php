<?php

namespace Signifly\Travy\Support;

use Illuminate\Support\Str;

class AttributeResolver
{
    /**
     * It resolves the value that should be passed for the front-end's attribute field.
     *
     * If an UnmappedProp object *is* passed, then its attribute field value will be used.
     *
     * If an UnmappedProp object is *not* passed, then the value passed in will be used.
     *
     * The fallback value will be used under the following conditions:
     *  - the value passed is falsey
     *  - an UnmappedProp is passed, but no attribute field value has been set
     * 
     * 
     * @param  [type] $value    [description]
     * @param  string $fallback [description]
     * @return [type]           [description]
     */
    public function resolve($value, string $fallback): string
    {
        if ($value instanceof UnmappedProp) {
            $value = $value->getAttribute();
        }

        if (! $value) {
            /** @todo Shouldn't the manipulation of the fallback should take place *before* being passed in...? */
            $value = str_replace(' ', '_', Str::lower($fallback));
        }

        return $value;
    }
}
