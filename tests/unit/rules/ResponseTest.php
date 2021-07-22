<?php

declare(strict_types=1);

use CallUp\Rules\Response;

final class ResponseTest extends PHPUnit\Framework\TestCase
{
  protected function setUp(): void
  {
  }

  public function testHasErrors(): void
  {
    $responseSuccess = new Response($this->mockSuccessResponse());
    $responseFail = new Response($this->mockFailResponse());

    $this->assertFalse($responseSuccess->hasErrors());
    $this->assertTrue($responseFail->hasErrors());
  }

  public function testGetErrors(): void
  {
    $response = new Response($this->mockFailResponse());
    $this->assertNotEquals([], $response->getErrors());
  }

  public function testGetData(): void
  {
    $response = new Response($this->mockSuccessResponse());
    $this->assertNotEquals([], $response->getData());
  }

  private function mockSuccessResponse(): stdClass
  {
    $response = new stdClass;
    $data = new stdClass;
    $cid = new stdClass;
    $code = new stdClass;

    $cid->prefix = '7487260';
    $cid->mask = '7487260****';
    $code->len = 4;

    $data->id = '7753d4e9-4a3a-4357-89b1-73.da757df8a2';
    $data->cid = $cid;
    $data->code = $code;

    $response->data = $data;
    $response->errors = null;

    return $response;
  }

  private function mockFailResponse(): stdClass
  {
    $response = new stdClass;
    $error = new stdClass;
    $error->message = 'access denied';
    $arr = [];
    array_push($arr, $error);

    $response->data = null;
    $response->errors = $arr;

    return $response;
  }
}