<?php

/**
 * Resource interface.
 *
 * Defines what methods should be implemented by resource.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

use LogicException;

/**
 * Interface ResourceInterface.
 */
interface ResourceInterface
{
    /**
     * Return URI for resource.
     *
     * Path should start with trailing slash.
     *
     * @throws LogicException
     */
    public function getPath(): string;

    /**
     * HTTP method.
     *
     * @throws LogicException
     */
    public function getMethod(): HttpMethod | string;

    /**
     * HTTP headers.
     *
     * @throws LogicException
     */
    public function getHeaders(): array;

    public function call(): mixed;
}
