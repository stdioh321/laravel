<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class Forbidden extends Exception
{
    public function __construct($message = "Forbidden", $code = 0, Throwable $previous = null)
    {
      parent::__construct($message, $code, $previous);
    }
}
