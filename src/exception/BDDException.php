<?php

class BDDException extends Exception
{
  public function __construct(?string $message, ?int $code)
  {
    parent::__construct($message, $code);
  }
}
