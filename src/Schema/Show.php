<?php

namespace Signifly\Travy\Schema;

class Show extends Action
{
    public function __construct($title, $status = null)
    {
        parent::__construct($title, $status);

        $this->type('show');
    }

    public function url(string $url)
    {
        return $this->endpoint($url, 'get');
    }
}
