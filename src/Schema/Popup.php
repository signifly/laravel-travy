<?php

namespace Signifly\Travy\Schema;

class Popup extends Action
{
    public function __construct($title, $status = null)
    {
        parent::__construct($title, $status);

        $this->type('popup');
        $this->text('Are you sure? Please confirm this action.');
    }
}
