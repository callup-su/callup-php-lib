<?php

declare(strict_types=1);

use CallUp\Rules\Validation;

final class ValidationTest extends PHPUnit\Framework\TestCase
{
  public function testPhone(): void
  {
    $validation = new Validation();
    $this->assertTrue($validation->phone('89537777777'));
    $this->assertTrue($validation->phone('375291147912'));
    $this->assertNotTrue($validation->phone('895355577'));
  }

  public function testOrderId(): void
  {
    $validation = new Validation();
    $this->assertTrue($validation->orderId('6999f209-5bb6-4581-9f91-5dba38812e13'));
    $this->assertNotTrue($validation->orderId(''));
  }

  public function testOrderCode(): void
  {
    $validation = new Validation();
    $this->assertTrue($validation->orderCode('1234'));
    $this->assertNotTrue($validation->orderCode(''));
  }
}