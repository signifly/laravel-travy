<?php

namespace Signifly\Travy\Support;

use Signifly\Travy\Http\Requests\TravyRequest;
use Signifly\Travy\Exceptions\InvalidDefinitionException;

class DefinitionFactory extends Factory
{
    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /** @var array */
    protected $validTypes = [
        'table',
        'view',
    ];

    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $type = $this->request->route()->parameter('type');

        $this->guardAgainstInvalidDefinitionType($type);

        switch ($type) {
            case 'table':
                return TableFactory::make($this->request);

            case 'view':
                return ViewFactory::make($this->request);
        }
    }

    /**
     * Guard against invalid definition type.
     *
     * @param  string $type
     * @return void
     */
    protected function guardAgainstInvalidDefinitionType(string $type)
    {
        throw_unless(
            in_array(strtolower($type), $this->validTypes),
            InvalidDefinitionException::class
        );
    }
}
