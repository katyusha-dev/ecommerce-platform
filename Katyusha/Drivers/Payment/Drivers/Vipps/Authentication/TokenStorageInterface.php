<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Authentication;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\Authentication\InvalidArgumentException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization\ResponseGetToken;

/**
 * Interface TokenStorageInterface.
 */
interface TokenStorageInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(): ResponseGetToken;

    public function set(ResponseGetToken $token): self;

    public function has(): bool;

    public function delete(): self;

    public function clear(): self;
}
