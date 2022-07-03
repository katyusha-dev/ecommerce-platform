<?php

/**
 * Resource base class.
 *
 * Abstract resource base class.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

use Doctrine\Common\Annotations\AnnotationRegistry;
use function Drivers\Clients\Payments\Vipps\Resource\implode;
use function Drivers\Clients\Payments\Vipps\Resource\str_replace;
use Exception;
use Http\Client\Exception\HttpException;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\VippsInterface;
use LogicException;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class ResourceBase.
 */
abstract class ResourceBase implements ResourceInterface, SerializableInterface
{
    protected VippsInterface $app;
    protected array $headers = [];
    protected string $body = '';
    protected string $id;
    protected string $path;
    protected mixed $method;
    protected Serializer $serializer;

    /**
     * AbstractResource constructor.
     *
     * @noinspection PhpDeprecationInspection
     */
    public function __construct(VippsInterface $vipps, string $subscription_key)
    {
        $this->app = $vipps;

        $this->headers['Ocp-Apim-Subscription-Key'] = $subscription_key;

        // Initiate serializer.
        AnnotationRegistry::registerLoader('class_exists');
        $this->serializer = SerializerBuilder::create()
            ->build();
    }

    /**
     * Gets serializer value.
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getMethod(): HttpMethod | string
    {
        if (! isset($this->method)) {
            throw new LogicException('Missing HTTP method');
        }

        return $this->method;
    }

    /**
     * {@inheritdoc}
     *
     * All occurrences of {id} pattern will be replaced with $this->id
     */
    public function getPath(): string
    {
        if (! isset($this->path)) {
            throw new LogicException('Missing resource path');
        }
        // Get local var.
        $path = $this->path;
        // If ID is set replace {id} pattern with model's ID.
        if (isset($this->id)) {
            $path = str_replace('{id}', $this->id, $path);
        }

        return $path;
    }

    /**
     * Sets path variable.
     *
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUri($path): UriInterface
    {
        return $this->app->getClient()->getEndpoint()->getUri()->withPath($path);
    }

    /**
     * @throws VippsException|ClientExceptionInterface
     */
    protected function makeCall(): ResponseInterface
    {
        try {
            $request = $this->getRequest();
            $response = $this->handleRequest($request);
        } catch (HttpException $e) {
            // Catch exceptions thrown by http client.
            // We must do that in order to normalize output.
            $response = $e->getResponse();
        } catch (Exception $e) {
            // Something went really bad here.
            throw new VippsException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    protected function handleRequest(RequestInterface $request): ResponseInterface
    {
        // Get client.
        $client = $this->app->getClient()->getHttpClient();

        // Handle requests, sync precedence.
        if ($client instanceof HttpClient) {
            // Send sync request.
            $response = $client->sendRequest($request);
        } elseif ($client instanceof HttpAsyncClient) {
            // Send async request.
            $response = $client->sendAsyncRequest($request)->wait();
        } else {
            throw new LogicException('Unknown HTTP Client type: '.implode(',', class_implements($client)));
        }

        return $response;
    }

    protected function getRequest(): RequestInterface
    {
        return new Request($this->getMethod(), $this->getUri($this->getPath()), $this->getHeaders(), $this->getBody());
    }

    /**
     * @throws VippsException
     */
    protected function handleResponse(ResponseInterface $response): ResponseInterface
    {
        // Handle request errors.
        if ($response->getStatusCode() >= 400) {
            throw VippsException::createFromResponse($response, $this->getSerializer());
        }

        // Sometimes VIPPS returns 200 with error message :/ They promised
        // to fix it but as a temporary fix we are gonna check if body is
        // "invalid" and throw exception in such a case.
        $exception = VippsException::createFromResponse($response, $this->getSerializer(), false);

        if ($exception instanceof VippsException) {
            throw $exception;
        }

        return $response;
    }
}
