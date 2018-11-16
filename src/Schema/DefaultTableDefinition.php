<?php

namespace Signifly\Travy\Schema;

class DefaultTableDefinition extends TableDefinition
{
    protected function schema()
    {
        $this->createActionFromResource();

        $this->loadFromResource();
    }
}
