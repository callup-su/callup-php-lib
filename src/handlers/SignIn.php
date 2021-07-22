<?php declare(strict_types=1);

namespace CallUp\Handlers;

use CallUp\Rules\Validation;
use Exception;

class HandlerSignIn
{
  public function prepareRequest(string $orderId, string $orderCode): array
  {
    return [
      'order_id'    => $orderId,
      'order_code'  => $orderCode
    ];
  }

  public function validate(array $input): void
  {
    if ((new Validation())->orderId($input['order_id']) === false) {
      throw new Exception('Неверный формат идентификатора заказа');
    }

    if ((new Validation())->orderCode($input['order_code']) === false) {
      throw new Exception('Неверный формат 4-х значного кода');
    }
  }
}