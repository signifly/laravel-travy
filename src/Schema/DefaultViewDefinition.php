<?php

namespace Signifly\Travy\Schema;

class DefaultViewDefinition extends ViewDefinition
{
    protected function schema()
    {
        $this->loadFromResource();

        $this->actions([
            Action::make('Delete', 'danger')
                ->icon('delete')
                ->type('popup')
                ->endpoint(
                    url("v1/admin/{$this->getResourceKey()}/{id}"),
                    function ($endpoint) {
                        $endpoint->usingMethod('delete');
                    }
                )
                ->onSubmit("/t/{$this->getResourceKey()}")
                ->text('Are you sure? Please confirm the action.'),
        ]);
    }
}
