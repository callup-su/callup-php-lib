<?php declare(strict_types=1);

namespace CallUp\Configuration;

use Dotenv\Dotenv;

class ConfigLoader
{
  private $dir;
  private $filename;
  private $params;

  public function loadByFile($dir = '', $filename = '.env')
  {
    $this->dir = $dir;
    $this->filename = $filename;
    return $this;
  }

  public function loadByParams(array $params)
  {
    $this->params = $params;
    return $this;
  }

  public function getConfig(): Config
  {
    $result = null;

    if ($this->params !== null) {
      $result = new Config($this->params);
    } else {
      $dir = $this->dir === '' ? dirname(__DIR__, 2) : $this->dir;
      $dotenv = Dotenv::createImmutable($dir, $this->filename);
      $dotenv->safeLoad();
      $result = $this->prepareConfig();
    }
    return $result;
  }

  private function prepareConfig(): Config
  {
    return new Config([
      'services' => [
        'CallPassword' => [
          'api_uri'     => $_ENV['CALL_PASSWORD_URI'],
          'api_token'   => $_ENV['CALL_PASSWORD_TOKEN']
        ]
      ]
    ]);
  }
}