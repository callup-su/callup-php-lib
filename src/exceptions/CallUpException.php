<?php declare(strict_types=1);

namespace CallUp\Exceptions;

use Exception;

class CallUpException extends Exception
{
  public function __construct(Exception $e)
  {
    parent::__construct($e->getMessage(), $e->getCode());
  }
}