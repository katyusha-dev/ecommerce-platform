<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use function Drivers\Clients\Payments\Vipps\sprintf;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MessageFactory;
use Katyusha\Drivers\Payment\Drivers\Vipps\Authentication\TokenMemoryCacheStorage;
use Katyusha\Drivers\Payment\Drivers\Vipps\Authentication\TokenStorageInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\Client\InvalidArgumentException;
use LogicException;

class Client implements ClientInterface
{
    protected HttpClient | HttpAsyncClient $httpClient;
    protected EndpointInterface $endpoint;
    protected MessageFactory $messageFactory;
    protected string $token;
    protected string $tokenType;
    protected TokenStorageInterface $tokenStorage;
    protected string $clientId;

    /**
     * VippsClient constructor.
     */
    public function __construct(string $client_id, array $options = [])
    {
        $this->setClientId($client_id);
        $this->setHttpClient($options['http_client'] ?? null);

        if (isset($options['endpoint']) && $options['endpoint'] === 'live') {
            $this->setEndpoint(Endpoint::live());
        } else {
            $this->setEndpoint(Endpoint::test());
        }

        $this->setTokenStorage($options['token_storage'] ?? new TokenMemoryCacheStorage());
    }

    /**
     * Gets token value.
     */
    public function getToken(): string
    {
        if (! isset($this->token)) {
            throw new InvalidArgumentException('Missing Token');
        }

        return $this->token;
    }

    /**
     * Gets tokenStorage value.
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    /**
     * Sets tokenStorage variable.
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage): self
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * Gets clientId value.
     */
    public function getClientId(): string
    {
        if (! isset($this->clientId)) {
            throw new InvalidArgumentException('Missing Client ID');
        }

        return $this->clientId;
    }

    /**
     * Sets clientId variable.
     */
    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Gets connection value.
     */
    public function getEndpoint(): EndpointInterface
    {
        return $this->endpoint;
    }

    /**
     * Sets connection variable.
     */
    public function setEndpoint(EndpointInterface $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Gets httpClient value.
     */
    public function getHttpClient(): HttpAsyncClient | HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Sets httpClient variable.
     */
    public function setHttpClient(mixed $httpClient): self
    {
        $this->httpClient = self::httpClientDiscovery($httpClient);
        unset($this->messageFactory);

        return $this;
    }

    public function getMessageFactory(): MessageFactory
    {
        if (! isset($this->messageFactory)) {
            $this->messageFactory = Psr17FactoryDiscovery::findResponseFactory();
        }

        return $this->messageFactory;
    }

    /**
     * Use this static method to get default HTTP Client.
     */
    protected function httpClientDiscovery(null | HttpClient | HttpAsyncClient $client = null): HttpClient | HttpAsyncClient
    {
        if (isset($client) && ($client instanceof HttpAsyncClient || $client instanceof HttpClient)) {
            return $client;
        }
        if (isset($client)) {
            throw new LogicException(sprintf('HttpClient must be instance of "%s" or "%s"', HttpClient::class, HttpAsyncClient::class));
        }

        return HttpClientDiscovery::find();
    }
}
