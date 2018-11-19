<?php

namespace Signifly\Travy\Schema;

class DefaultViewDefinition extends ViewDefinition
{
    protected function schema()
    {
        $this->loadFromResource();
    }
}
