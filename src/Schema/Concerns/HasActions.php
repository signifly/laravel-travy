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
     * @param string $title
     * @param string $status
     * @return \Signifly\Travy\Table\Actions\Action
     */
    public function addAction($title, $status = null)
    {
        $action = new Action($title, $status);

        array_push($this->actions, $action);

        return $action;
    }

    /**
     * Add action from a callable definition.
     *
     * @param string $action
     */
    public function addActionFor(string $action)
    {
        $class = new $action;

        if (! is_callable($class)) {
            throw new Exception($action . " must be callable.");
        }

        return $class($this);
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
        return collect($this->actions)->map->toArray();
    }
}
