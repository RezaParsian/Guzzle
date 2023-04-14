<?php

namespace Rp76\Guzzle;

use Closure;
use Exception;
use GuzzleHttp\{Exception\ClientException, Exception\GuzzleException, Exception\ServerException, Psr7\Response, TransferStats};
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Psr\Log\LoggerInterface;

/**
 * @method getHeader(string $header)
 * @method getHeaders()
 */
class Client extends \GuzzleHttp\Client
{
    public array $options;
    public RequestInterface $request;
    public TransferStats $stats;

    protected ?Closure $beforeRequest = null;
    protected ?Closure $afterRequest = null;
    protected LoggerInterface $logger;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->logger = new Monolog('RP76', [
            new StreamHandler(explode('/vendor', __DIR__)[0] . '/storage/logs/guzzle/rp76-' . date('Y-m-d') . '.log', Monolog::WARNING)
        ]);
    }

    /**
     * @param Closure|null $beforeRequest
     */
    public function setBeforeRequest(?Closure $beforeRequest): void
    {
        $this->beforeRequest = $beforeRequest;
    }

    /**
     * @param Closure|null $afterRequest
     */
    public function setAfterRequest(?Closure $afterRequest): void
    {
        $this->afterRequest = $afterRequest;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        $response = new Response(408);

        $options["on_stats"] = function (TransferStats $stats) {
            $this->stats = $stats;
        };

        $this->options = $options;
        $this->request = $request;

        if ($this->beforeRequest)
            ($this->beforeRequest)($request, $options);

        try {
            $response = parent::send($request, $options);
        } catch (ClientException | ServerException $exception) {
            $response = $exception->getResponse();
        } catch (Exception $exception) {
            $this->logger->error("Client Exception: ", [
                "Error" => $exception->getMessage(),
                "Url" => $request->getUri(),
                "Options" => $options,
            ]);
        }

        if ($this->afterRequest)
            ($this->afterRequest)($request, $response, $options);

        return $response;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseData
     * @throws GuzzleException
     */
    public function easySend(RequestInterface $request, array $options = []): ResponseData
    {
        return new ResponseData($this, $this->send($request, $options));
    }
}
