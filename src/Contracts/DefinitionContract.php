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

    /**
     * Set the default resource key.
     *
     * @param string $resourceKey
     */
    public function setDefaultResourceKey(string $resourceKey);
}
