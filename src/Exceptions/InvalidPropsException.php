<?php

namespace Signifly\Travy\Exceptions;

use Exception;
use Illuminate\Contracts\Support\MessageBag;

class InvalidPropsException extends Exception
{
    public $errors;

    public function __construct(MessageBag $errors, $message = null, $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }
}
