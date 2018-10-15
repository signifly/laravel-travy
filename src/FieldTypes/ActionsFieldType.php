<?php

namespace Signifly\Travy\FieldTypes;

use Closure;
use Signifly\Travy\Schema\Action;

class ActionsFieldType extends FieldType
{
    protected $id = 'vActions';

    protected $actions = [];

    public function addItem($title, Closure $callback)
    {
        $action = new Action($title);

        $callback($action);

        $action = $action->toArray();

        array_push($this->actions, $action);

        return $this;
    }

    public function prependItem($title, Closure $callback)
    {
        $action = new Action($title);

        $callback($action);

        $action = $action->toArray();

        array_unshift($this->actions, $action);

        return $this;
    }

    protected function beforeBuild()
    {
        $this->addProp('actions', $this->actions);
    }
}
