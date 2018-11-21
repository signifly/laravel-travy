<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Action;
use Signifly\Travy\Schema\Column;
use Signifly\Travy\Fields\Actions;

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

        // Set actions
        $column = Column::make(
            Actions::make('Actions')
                ->actions([
                    Action::make('View')
                        ->type('show')
                        ->endpoint("/t/{$this->getResourceKey()}/{id}", 'get'),

                    Action::make('Delete')
                        ->type('popup')
                        ->endpoint(url("v1/admin/{$this->getResourceKey()}/{id}"), 'delete')
                        ->text('Are you sure? Please confirm this action.')
                ])
                ->width(120)
        );
        $this->addColumn($column);
    }
}
