<?php declare(strict_types=1);

use CallUp\Handlers\HandlerSignIn;

final class SignInTest extends PHPUnit\Framework\TestCase
{
  private $handler;

  protected function setUp(): void
  {
    $this->handler = new HandlerSignIn();
  }

  public function testPrepareRequest(): void
  {
    $source = [
      'order_id'    => '6999f209-5bb6-4581-9f91-5dba38812e13',
      'order_code'  => '1234'
    ];

    $this->assertTrue(
      $this->arraysAreSimilar($source, $this->handler->prepareRequest('6999f209-5bb6-4581-9f91-5dba38812e13', '1234'))
    );
    $this->assertNotTrue(
      $this->arraysAreSimilar($source, $this->handler->prepareRequest('', ''))
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
      'Invalid order id' => [
        [
          'data' => ['order_id' => '', 'order_code' => '1234'],
          'errorMessage' => 'Неверный формат идентификатора заказа'
        ],
      ],
      'Invalid order code' => [
        [
          'data' => ['order_id' => '6999f209-5bb6-4581-9f91-5dba38812e13', 'order_code' => ''],
          'errorMessage' => 'Неверный формат 4-х значного кода'
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