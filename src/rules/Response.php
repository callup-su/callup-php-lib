<?php declare(strict_types=1);

namespace CallUp\Rules;

use stdClass;

class Response
{
  private $input;

  public function __construct(stdClass $input)
  {
    $this->input = $input;
  }

  public function hasErrors(): bool
  {
    $hasError = false;

    if (property_exists($this->input, 'errors')) {
      $errors = $this->input->errors;

      if ($errors !== null) {
        $hasError = true;
      }
    }
    return $hasError;
  }

  public function getErrors(): array
  {
    return $this->getParameter('errors', $this->input->errors);
  }

  public function getData(): array
  {
    return $this->getParameter('data', $this->input->data);
  }

  private function getParameter(string $field, $data): array
  {
    return (property_exists($this->input, $field))
      ? (array)$data
      : [];
  }
}