<?php declare(strict_types=1);

namespace CallUp\Configuration;

final class ConfigCallPassword
{
  private $config;

  public function __construct(array $config)
  {
    $this->config = $config;
  }

  public function getUri(): string
  {
    return $this->getParameter('api_uri');
  }

  public function getToken(): string
  {
    return $this->getParameter('api_token');
  }

  private function getParameter(string $name): string
  {
    return (array_key_exists($name, $this->config))
      ? $this->config[$name]
      : '';
  }
}