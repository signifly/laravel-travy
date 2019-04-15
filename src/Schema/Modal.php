<?php

namespace Signifly\Travy\Schema;

class Modal extends Action
{
    public function __construct($title, $status = null)
    {
        parent::__construct($title, $status);

        $this->type('modal');
    }
}
