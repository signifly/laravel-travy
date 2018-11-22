<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Action;

class DefaultViewDefinition extends ViewDefinition
{
    protected function schema()
    {
        $this->loadFromResource();

        $this->actions([
            Action::make('Delete', 'danger')
                ->icon('delete')
                ->type('popup')
                ->endpoint(url("v1/admin/{$this->getResourceKey()}/{id}"), 'delete')
                ->onSubmit("/t/{$this->getResourceKey()}")
                ->text('Are you sure? Please confirm the action.'),
        ]);
    }
}
