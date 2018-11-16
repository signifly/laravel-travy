<?php

namespace Signifly\Travy\Schema\Concerns;

use Exception;
use Signifly\Travy\Schema\Action;

trait HasActions
{
    /**
     * The actions array.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Add action to the definition schema.
     *
     * @param  \Signifly\Travy\Schema\Action $action
     * @return \Signifly\Travy\Schema\Action
     */
    public function addAction(Action $action)
    {
        array_push($this->actions, $action);

        return $action;
    }

    /**
     * Determine if there are any actions.
     *
     * @return bool
     */
    public function hasActions()
    {
        return count($this->actions) > 0;
    }

    /**
     * Get the prepared actions.
     *
     * @return array
     */
    protected function preparedActions()
    {
        return collect($this->actions)
            ->map(function ($action) {
                return $action->jsonSerialize();
            })
            ->toArray();
    }
}
