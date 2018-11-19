<?php

namespace Signifly\Travy\Support;

class RulesetSorter
{
    /** @var array */
    protected $rules = [];

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public static function makeFor()
    {
        return (new static(...func_get_args()))->make();
    }

    public function make()
    {
        return collect($this->rules)
            ->map(function ($rules, $attribute) {
                return collect($rules)
                    ->sortBy(function ($rule, $key) {
                        if ($rule == 'required') {
                            return -1;
                        }

                        return $key;
                    })
                    ->values();
            })
            ->toArray();
    }
}
