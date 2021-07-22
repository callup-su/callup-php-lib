<?php declare(strict_types=1);

use CallUp\Configuration\Config;
use CallUp\Configuration\ConfigLoader;

final class ConfigLoaderTest extends PHPUnit\Framework\TestCase
{
  private $params;

  protected function setUp(): void
  {
    $this->params = [
      'services' => [
        'CallPassword' => [
          'api_uri'     => 'api.callup.service',
          'api_token'   => 'secret_token'
        ]
      ]
    ];
  }

  /**
   * @test
   *
   */
  public function testLoadByFile(): void
  {
    $config = (new ConfigLoader())
      ->loadByFile(dirname(__DIR__, 3), '.env.testing')
      ->getConfig();
    $this->checkFields($config);
  }

  /**
   * @test
   *
   */
  public function testLoadByParams(): void
  {
    $config = (new ConfigLoader())
      ->loadByParams($this->params)
      ->getConfig();
    $this->checkFields($config);
  }

  /**
   * @test
   *
   */
  public function testGetConfig(): void
  {
    $configObject = (new ConfigLoader())
      ->loadByParams($this->params)
      ->getConfig();
    $this->assertInstanceOf(Config::class, $configObject);
  }

  private function checkFields(Config $config): void
  {
    $this->assertEquals(
      $this->params['services']['CallPassword']['api_uri'],
      $config->getCallPassword()->getUri()
    );
    $this->assertEquals(
      $this->params['services']['CallPassword']['api_token'],
      $config->getCallPassword()->getToken()
    );
  }
}