<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ServerException extends Exception
{

  protected $exMessage;

  public function __construct($message = "Server Error", $code = 500, Throwable $previous = null, $exMessage = "Server Error")
  {
    $this->setExMessage($exMessage);
    parent::__construct($message, $code, $previous);
  }

  /**
   * @return mixed
   */
  public function getExMessage()
  {
    return $this->exMessage;
  }

  /**
   * @param mixed $exMessage
   */
  public function setExMessage($exMessage): void
  {
    $this->exMessage = $exMessage;
  }


}
