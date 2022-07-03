<?php

/**
 * Connection base class.
 *
 * Abstract connection base class.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use Eloquent\Enumeration\AbstractMultiton;
use Eloquent\Enumeration\Exception\ExtendsConcreteException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\UriInterface;
use ReflectionClass;
use function sprintf;

/**
 * Class ConnectionBase.
 *
 * @method static EndpointInterface test()
 * @method static EndpointInterface live()
 */
class Endpoint extends AbstractMultiton implements EndpointInterface
{
    public static $live = [
        'scheme' => 'https',
        'host' => 'api.vipps.no',
        'port' => 443,
        'path' => '',
    ];

    public static $test = [
        'scheme' => 'https',
        'host' => 'apitest.vipps.no',
        'port' => 443,
        'path' => '',
    ];

    protected string $scheme;
    protected string $host;
    protected int $port;
    protected string $path;

    protected function __construct($key, $scheme, $host, $port, $path)
    {
        parent::__construct($key);
        $this->scheme = $scheme;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
    }

    /**
     * Gets scheme value.
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * Gets host value.
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Gets port value.
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * Gets path value.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get connection base uri.
     */
    public function getUri(): UriInterface
    {
        $uri = Psr17FactoryDiscovery::findUriFactory();

        return $uri->createUri(sprintf(
            '%s://%s:%s%s',
            $this->getScheme(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath()
        ));
    }

    /**
     * @throws ExtendsConcreteException
     */
    protected static function initializeMembers(): void
    {
        $reflectionClass = new ReflectionClass(self::class);
        foreach ($reflectionClass->getStaticProperties() as $staticPropertyName => $staticPropertyValue) {
            new static(
                $staticPropertyName,
                $staticPropertyValue['scheme'],
                $staticPropertyValue['host'],
                $staticPropertyValue['port'],
                $staticPropertyValue['path']
            );
        }
    }
}
