<?php declare(strict_types=1);

namespace CallUp\Handlers;

use CallUp\Rules\Validation;
use Exception;

class HandlerVerify
{
  public function prepareRequest(string $phone): array
  {
    return ['phone' => $phone];
  }

  public function validate(array $input): void
  {
    if ((new Validation())->phone($input['phone']) === false) {
      throw new Exception('Неверный формат номера телефона');
    }
  }
}