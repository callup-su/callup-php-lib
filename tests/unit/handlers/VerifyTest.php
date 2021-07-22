<?php

declare(strict_types=1);

use CallUp\Handlers\HandlerVerify;

final class VerifyTest extends PHPUnit\Framework\TestCase
{
  private $handler;

  protected function setUp(): void
  {
    $this->handler = new HandlerVerify();
  }

  public function testPrepareRequest(): void
  {
    $source = [
      'phone' => '89537777777'
    ];

    $this->assertTrue(
      $this->arraysAreSimilar($source, $this->handler->prepareRequest('89537777777'))
    );
    $this->assertNotTrue(
      $this->arraysAreSimilar($source, $this->handler->prepareRequest('8953555777'))
    );
  }

  /**
   * @test
   *
   * @dataProvider validationProvider
   */
  public function testValidateTest($options): void
  {
    $errMsg = null;
    try {
      $this->handler->validate($options['data']);
    } catch (Exception $e) {
      $errMsg = $e->getMessage();
    }
    $this->assertEquals($errMsg, $options['errorMessage']);
  }

  public function validationProvider()
  {
    return [
      'Invalid phone number' => [
        [
          'data' => ['phone' => '895355577'],
          'errorMessage' => 'Неверный формат номера телефона'
        ]
      ]
    ];
  }

  private function arraysAreSimilar($a, $b): bool
  {
    if (count(array_diff_assoc($a, $b))) {
      return false;
    }

    foreach($a as $k => $v) {
      if ($v !== $b[$k]) {
        return false;
      }
    }
    return true;
  }
}