<?php

namespace Signifly\Travy\Schema;

class DefaultTableDefinition extends TableDefinition
{
    protected function schema()
    {
        // Activiate sequential editing
        $this->buildBatch(
            $this->batchLabelFromResource(),
            "/t/{$this->getResourceKey()}/{id}"
        );

        // Set create action from resource
        $this->createActionFromResource();

        // Set columns, filters, includes and modifiers from resource
        $this->loadFromResource();
    }
}
