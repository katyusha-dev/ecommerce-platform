<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Katyusha\Drivers\Payment\Drivers\Vipps\Authentication\TokenStorageInterface;

interface ClientInterface
{
    public function getTokenStorage(): TokenStorageInterface;

    /**
     * Storage container for the token.
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage): self;

    /**
     * Gets clientId value.
     */
    public function getClientId(): string;

    /**
     * Sets clientId variable.
     */
    public function setClientId(string $clientId): self;

    /**
     * Gets connection value.
     */
    public function getEndpoint(): EndpointInterface;

    /**
     * Sets connection variable.
     */
    public function setEndpoint(EndpointInterface $endpoint): self;

    /**
     * Gets httpClient value.
     */
    public function getHttpClient(): HttpAsyncClient | HttpClient;

    /**
     * Sets httpClient variable.
     */
    public function setHttpClient(HttpAsyncClient | HttpClient $httpClient): self;

    /**
     * Gets messageFactory value.
     */
    public function getMessageFactory(): void;
}
