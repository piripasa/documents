<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidFileException extends HttpException
{
    public function __construct($message = null)
    {
        parent::__construct(400, $message);
    }
}
