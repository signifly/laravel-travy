<?php

namespace Signifly\Travy\Schema\Contracts;

interface DefinitionContract
{
    /**
     * Build the schema.
     *
     * @return array
     */
    public function build() : array;
}
