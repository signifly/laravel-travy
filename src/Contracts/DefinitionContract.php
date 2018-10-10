<?php

namespace Signifly\Travy\Contracts;

interface DefinitionContract
{
    /**
     * Build the schema.
     *
     * @return array
     */
    public function build() : array;
}
