<?php

namespace exception;

use Exception;

class ActionException extends Exception
{
    private string $redirection;
    public function __construct(string $message, string $redirection)
    {
        parent::__construct($message);
        $this->redirection = $redirection;
    }
}