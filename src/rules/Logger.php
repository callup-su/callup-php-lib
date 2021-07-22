<?php declare(strict_types=1);

namespace CallUp\Rules;

class Logger
{
  public function write(string $message, int $type)
  {
    error_log($message, $type);
  }
}