<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, 400);
    }
}
