<?php declare(strict_types=1);

namespace CallUp\Rules;

class Validation
{
  public function phone(string $phone): bool
  {
    return preg_match('/^\d{10,16}$/', $phone)
      ? true
      : false;
  }

  public function orderId(string $id): bool
  {
    return is_string($id) && $id !== '';
  }

  public function orderCode(string $code): bool
  {
    return preg_match('/^\d{1,6}$/', $code)
      ? true
      : false;
  }
}