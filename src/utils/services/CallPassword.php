<?php declare(strict_types=1);

namespace CallUp\Utils\Services;

use CallUp\Configuration\ConfigCallPassword;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class CallPassword
{
  private $headers;
  private $uri;

  public function __construct(ConfigCallPassword $config)
  {
    $this->uri = $config->getUri();
    $this->headers = [
      'Accept'              => '*',
      'Content-Type'        => 'application/json',
      'X-Application-Token' => $config->getToken()
    ];
  }

  public function orders(array $input): ResponseInterface
  {
    return (new Client())->send(
      new Request(
        'POST',
        $this->uri . '/v1/orders',
        $this->headers,
        json_encode($input)
      )
    );
  }

  public function auth(array $input): ResponseInterface
  {
    return (new Client())->send(
      new Request(
        'GET',
        "{$this->uri}/v1/auth/{$input['order_id']}/{$input['order_code']}",
        $this->headers
      )
    );
  }
}