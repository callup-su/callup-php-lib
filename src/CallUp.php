<?php declare(strict_types=1);

namespace CallUp;

use CallUp\Configuration\ConfigLoader;
use CallUp\Exceptions\CallUpException;
use CallUp\Handlers\HandlerSignIn;
use CallUp\Handlers\HandlerVerify;
use CallUp\Rules\Logger;
use CallUp\Rules\Response;
use CallUp\Utils\Services\CallPassword;
use Exception;

class CallUp
{
  private $config;

  public function __construct($params = [], $dir = '', $filename = '')
  {
    $this->config = (new ConfigLoader())
      ->loadByParams($params)
      ->loadByFile($dir, $filename)
      ->getConfig();
  }

  public function verify(string $phone): Response
  {
    try {
      $handler = new HandlerVerify();
      $service = new CallPassword($this->config->getCallPassword());
      $input = $handler->prepareRequest($phone);
      $handler->validate($input);
      $response = $service->orders($input);
      $jsonResponse = json_decode($response->getBody()->getContents());
    } catch (Exception $e) {
      $this->catchException($e);
    }
    return new Response($jsonResponse);
  }

  public function signIn(string $id, string $code): Response
  {
    try {
      $handler = new HandlerSignIn();
      $service = new CallPassword($this->config->getCallPassword());
      $input = $handler->prepareRequest($id, $code);
      $handler->validate($input);
      $response = $service->auth($input);
      $jsonResponse = json_decode($response->getBody()->getContents());
    } catch (Exception $e) {
      $this->catchException($e);
    }
    return new Response($jsonResponse);
  }

  private function catchException(Exception $e): void
  {
    if ($this->config->getParameter('logger') ?? false) {
      (new Logger())->write($e->getMessage(), $e->getCode());
    }
    throw new CallUpException($e);
  }
}
