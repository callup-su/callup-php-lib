<?php declare(strict_types=1);

namespace CallUp\Configuration;

class Config
{
  private $config;

  public function __construct(array $config)
  {
    $this->config = $config;
  }

  public function getConfig(): array
  {
    return $this->config;
  }

  public function getParameter(string $name): string
  {
    return array_key_exists($name, $this->config)
      ? $this->config[$name]
      : '';
  }

  public function getCallPassword(): ?ConfigCallPassword
  {
    $service = $this->getService('CallPassword');
    if ($service !== null) {
      $service = new ConfigCallPassword($service);
    }
    return $service;
  }

  private function getService(string $name): ?array
  {
    $service = null;
    if (array_key_exists('services', $this->config)) {
      if (array_key_exists($name, $this->config['services'])) {
        $service = $this->config['services'][$name];
      }
    }
    return $service;
  }
}
