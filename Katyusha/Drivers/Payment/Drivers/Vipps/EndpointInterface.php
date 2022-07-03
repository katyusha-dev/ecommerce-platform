<?php

/**
 * Connection interface.
 *
 * Interface which defines connections.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps;

use Psr\Http\Message\UriInterface;

/**
 * Interface ConnectionInterface.
 */
interface EndpointInterface
{
    public function getScheme(): string;

    public function getHost(): string;

    public function getPort(): string;

    public function getPath(): string;

    /**
     * Returns base URI for requests against VIPPS servers.
     */
    public function getUri(): UriInterface;
}
