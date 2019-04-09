<?php

namespace Signifly\Travy\Contracts;

interface Definition
{
    /**
     * Build the schema.
     *
     * @return array
     */
    public function build(): array;
}
