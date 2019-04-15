<?php

namespace Signifly\Travy\Schema;

class Dropdown extends Action
{
    public function __construct($title, $status = null)
    {
        parent::__construct($title, $status);

        $this->type('dropdown');
        $this->icon('arrow-down');
    }
}
